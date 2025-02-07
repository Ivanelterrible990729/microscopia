<?php

namespace App\Services;

use App\Enums\Media\MediaEnum;
use App\Models\Image;
use Illuminate\Support\Str;
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
        $filename = $info['filename'];
        $extension = $info['extension'];

        $customFileName = $this->generateCustomFileName(extension: $extension);
        $labels = $image->labels->pluck('name')->toArray();

        if (empty($labels)) {
            $image->addMedia($file)
                ->usingName($filename . '.' . $extension)
                ->usingFileName($customFileName)
                ->preservingOriginal($preservingOriginal)
                ->toMediaCollection(MediaEnum::Images->value);
            return;
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

    public function syncMedia(Image $image)
    {

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
    private function generateCustomFileName($extension): string
    {
        return Str::uuid() . '-' . time() . '.' . $extension;
    }
}
