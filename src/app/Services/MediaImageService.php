<?php

namespace App\Services;

use App\Enums\Media\MediaEnum;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class MediaImageService
{
    /**
     * Considera 3 casos:
     * - Cuando la imagen no tiene etquetas, se guarda la colección MediaEnum::Image->value.
     * - Cuando la imagen tiene una etiqueta, se guarda la colección en la etiqueta especificada.
     * - Cuando la imagen tiene n etiquetas, se guardan n imagenes correspondientes a cada etiqueta.
     */
    public function addMedia(Image $image, string|UploadedFile $file, bool $preservingOriginal = false): void
    {
        $info = $this->getFileName($file);
        $filename = sanitizeFileName($info['filename']);
        $extension = $info['extension'];

        $customFileName = $this->generateCustomFileName(filename: $filename, extension: $extension);
        $labels = $image->labels->pluck('folder_name')->toArray();

        if (empty($labels)) {
            $labels = [MediaEnum::Images->value];
        }

        $last_key = array_key_last($labels);

        foreach ($labels as $key => $labelName) {
            if ($key === $last_key) {
                $image->addMedia($file)
                    ->usingName($filename . '.' . $extension)
                    ->usingFileName($customFileName)
                    ->preservingOriginal($preservingOriginal)
                    ->toMediaCollection($labelName);
            } else {
                $image->addMedia($file)
                    ->usingName($filename . '.' . $extension)
                    ->usingFileName($customFileName)
                    ->preservingOriginal(true)
                    ->toMediaCollection($labelName);
            }
        }
    }

    /**
     * - Se recupera la imagen original.
     * - Se eliminan las colecciones de la imagen.
     * - Se crean las colecciones que correspondan.
     */
    public function syncMedia(Image $image)
    {
        $firstMedia = $image->getFirstMedia('*');

        $path = 'livewire-tmp/' . $firstMedia->name;
        Storage::disk(config('filesystems.default', 'public'))->put($path, file_get_contents($firstMedia->getPath()));

        $image->media()->get()->each->delete();

        $this->addMedia(
            image: $image,
            file: Storage::disk(config('filesystems.default', 'public'))->path($path),
            preservingOriginal: false,
        );
    }

    private function getFileName(string|UploadedFile $file): array
    {
        if (!is_string($file)) {
            $file = $file->getClientOriginalName();
        }

        return pathinfo($file);
    }

    /**
     * Genera un nuevo nombre de archivo para evitar incongruencias en el almacenamiento.
     */
    private function generateCustomFileName(string $filename, string $extension): string
    {
        return md5(config('app.key') . $filename) . '.' . $extension;
    }
}
