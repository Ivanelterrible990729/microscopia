<?php

namespace App\Services;

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
        Storage::disk(config('filesystems.default'))->makeDirectory(self::ORIGINAL_DIRECTORY);
        Storage::disk(config('filesystems.default'))->makeDirectory(self::CROPPED_DIRECTORY);
        Storage::disk(config('filesystems.default'))->makeDirectory(self::AUGMENTED_DIRECTORY);

        $selected_directories = array_map(
            fn($id) => 'images/' . $availableLabels[array_search($id, array_column($availableLabels, 'id'))]['folder_name'],
            $selectedLabels
        );

        foreach ($selected_directories as $key => $directory) {
            $images = Storage::disk(config('filesystems.default'))->files($directory);
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
                Storage::disk(config('filesystems.default'))->move($imagePath, self::ORIGINAL_DIRECTORY . '/' . $folderName . '/' . $fileName);

                if ($maxNum == $maxNumImages) {
                    break;
                }
            }
        }

        return count($selected_directories);
    }

    /**
     * Resuelve el ambiente para el entrenamiento:
     * - Mueve las imagenes a su ubicación original.
     * - Elimina los directorios creados con anterioridad.
     */
    public static function removeEnvironment(): void
    {
        $directories = Storage::disk(config('filesystems.default'))->directories(self::ORIGINAL_DIRECTORY);

        foreach ($directories as $directory) {
            $images = Storage::disk(config('filesystems.default'))->files($directory);
            $folderName = pathinfo($directory, PATHINFO_BASENAME);

            foreach ($images as $imagePath) {
                $filename = pathinfo($imagePath, PATHINFO_BASENAME);
                Storage::disk(config('filesystems.default'))->move($imagePath, 'images/' . $folderName . '/' . $filename);
            }
        }

        Storage::disk(config('filesystems.default'))->deleteDirectory(self::TRAINING_WORKSPACE);
    }
}
