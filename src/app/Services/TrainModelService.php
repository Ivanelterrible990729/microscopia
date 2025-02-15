<?php

namespace App\Services;

use App\Enums\CnnModel\AvailableModelsEnum;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TrainModelService
{
    /**
     * Directorio del ambiente de entrenamiento.
     */
    public const TRAINING_WORKSPACE = 'training-workspace';

    /**
     * Referencia al directorio donde el dataset está original
     */
    public const ORIGINAL_DIRECTORY = 'training-workspace/Original';

    /**
     * Referencia al directoro donde el dataset está recortado
     */
    public const CROPPED_DIRECTORY = 'training-workspace/Cropped';

    /**
     * Referencia al directorio está augmentado.
     */
    public const AUGMENTED_DIRECTORY = 'training-workspace/Augmented';

    /**
     * Descarga el modelo enlazado al modelo.
     */
    public static function downloadModel(Media $modelMedia): BinaryFileResponse
    {
        return response()->download($modelMedia->getPath(), $modelMedia->file_name);
    }

    /**
     *  Crea el ambiente para el entrenamiento:
     * - Crea los directorios para el entrenamiento
     * - Mueve las imagenes que serán entrenadas.
     */
    public static function createEnvironment(array $availableLabels, array $selectedLabels, int $maxNumImages): int
    {
        Storage::disk(config('filesystems.default', 'public'))->makeDirectory(self::ORIGINAL_DIRECTORY);
        Storage::disk(config('filesystems.default', 'public'))->makeDirectory(self::CROPPED_DIRECTORY);
        Storage::disk(config('filesystems.default', 'public'))->makeDirectory(self::AUGMENTED_DIRECTORY);

        $selected_directories = array_map(
            fn($id) => 'images/' . $availableLabels[array_search($id, array_column($availableLabels, 'id'))]['folder_name'],
            $selectedLabels
        );

        foreach ($selected_directories as $key => $directory) {
            $images = Storage::disk(config('filesystems.default', 'public'))->files($directory);
            $deletedImages = Media::with('model')
                ->where('collection_name', $availableLabels[$key]['folder_name'])
                ->where('model_type', Image::class)
                ->get()
                ->where('model.deleted_at', '!=', null)
                ->map(function($media) {
                    return $media->getPathRelativeToRoot();
                })->toArray();

            $maxNum = 1;
            $imagesToTrain = array_diff($images, $deletedImages);
            $folderName = $availableLabels[$key]['folder_name'];

            foreach ($imagesToTrain as $imagePath) {
                $fileName = pathinfo($imagePath, PATHINFO_BASENAME);
                // Si se quisiese mover las imagenes en lugar de copiar, puedes usar la función move. Nota: Go to removeEnvironment():
                Storage::disk(config('filesystems.default', 'public'))->copy($imagePath, self::ORIGINAL_DIRECTORY . '/' . $folderName . '/' . $fileName);

                if ($maxNum == $maxNumImages) {
                    break;
                }
            }
        }

        return count($selected_directories);
    }

    /**
     * Realiza el recorte de las imagenes para evitar el ruido que puderan ocasionar
     * las métricas de las muestras.
     */
    public static function cropImages(): int
    {
        $args = [
            '--input_dir' => Storage::disk(config('filesystems.default', 'public'))->path(self::ORIGINAL_DIRECTORY),
            '--output_dir' => Storage::disk(config('filesystems.default', 'public'))->path(self::CROPPED_DIRECTORY),
            '--percentage' => 92,
        ];

        $pythonService = new PythonService();
        $output = $pythonService->runScript(
            script: 'crop_images.py',
            args: $args
        );

        $output = array_values(array_slice($output, -1, 1, true));

        if (count($output) != 1) {
            return 0;
        }

        return (int) $output[0];
    }

    /**
     * Realiza la augmentación de los datos
     */
    public static function augmentImages(): int
    {
        $args = [
            '--input_dir' => Storage::disk(config('filesystems.default', 'public'))->path(self::CROPPED_DIRECTORY),
            '--output_dir' => Storage::disk(config('filesystems.default', 'public'))->path(self::AUGMENTED_DIRECTORY),
        ];

        $pythonService = new PythonService();
        $output = $pythonService->runScript(
            script: 'image_augmentation.py',
            args: $args
        );

        $output = array_values(array_slice($output, -1, 1, true));

        if (count($output) != 1) {
            return 0;
        }

        return (int) $output[0];
    }

    /**
     * Realiza el entrenamiento del modelo
     */
    public static function trainModel(array $availableLabels, array $selectedLabels, $modelDirectory, string $validationPortion)
    {
        $classNames = array_map(
            fn($id) => $availableLabels[array_search($id, array_column($availableLabels, 'id'))]['folder_name'],
            $selectedLabels
        );

        $args = [
            '--class_names' => json_encode($classNames),
            '--model_directory' => $modelDirectory,
            '--data_directory' => Storage::disk(config('filesystems.default', 'public'))->path(self::AUGMENTED_DIRECTORY),
            '--validation_portion' => $validationPortion,
            '--is_base_model' => in_array($modelDirectory, array_keys(AvailableModelsEnum::arrayResource())) ? "1" : "0",
            '--output_dir' => Storage::disk(config('filesystems.default', 'public'))->path(self::TRAINING_WORKSPACE),
        ];

        $pythonService = new PythonService();
        $output = $pythonService->runScript(
            script: 'train_model.py',
            args: $args
        );

        $output = array_values(array_slice($output, -5, 5, true));

        if (count($output) != 5) {
            return [];
        }

        return [
            'model_path' => $output[0],
            'accuracy' => $output[1],
            'loss' => $output[2],
            'val_accuracy' => $output[3],
            'val_loss' => $output[4],
        ];
    }

    /**
     * Resuelve el ambiente para el entrenamiento:
     * - Mueve las imagenes a su ubicación original.
     * - Elimina los directorios creados con anterioridad.
     */
    public static function removeEnvironment(): void
    {
        // Este fragmento se utiliza SÍ O SOLO SÍ al momento de crear el ambiente, en lugar de copiar los archivos, se mueven.
        // Este código comentado devuelve las imagenes a su directorio original.
        // $directories = Storage::disk(config('filesystems.default', 'public'))->directories(self::ORIGINAL_DIRECTORY);

        // foreach ($directories as $directory) {
        //     $images = Storage::disk(config('filesystems.default', 'public'))->files($directory);
        //     $folderName = pathinfo($directory, PATHINFO_BASENAME);

        //     foreach ($images as $imagePath) {
        //         $filename = pathinfo($imagePath, PATHINFO_BASENAME);
        //         Storage::disk(config('filesystems.default', 'public'))->move($imagePath, 'images/' . $folderName . '/' . $filename);
        //     }
        // }

        Storage::disk(config('filesystems.default'), 'public')->deleteDirectory(self::TRAINING_WORKSPACE);
    }
}
