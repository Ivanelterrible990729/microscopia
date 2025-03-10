<?php

namespace App\Services;

use App\Contracts\Services\ActivityInterface;
use App\Models\Image;
use App\Repositories\ImageRepository;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ImageService
{
    /**
     * Activitylog está registrado en los eventos created & updated en Image.php
     */
    public function __construct(
        protected ImageRepository $imageRepository,
        protected MediaImageService $mediaImageService,
        protected ActivityInterface $activityService,
    ) {}

    /**
     * Implementa lógica para guardar las imagenes en BD.
     */
    public function storeImages(array $files): array
    {
        $imageIds = [];

        foreach ($files as $file) {
            $image = $this->imageRepository->create([
                'user_id' => request()->user()->id,
                'name' => $file->getClientOriginalName(),
            ]);

            $this->mediaImageService->addMedia(
                image: $image,
                file: $file,
                preservingOriginal: false
            );

            $imageIds[] = $image->id;
        }

        return $imageIds;
    }

    /**
     * Actualiza el contenido del modelo Image.
     */
    public function updateImage(Image $image, array $data): Image
    {
        $this->imageRepository->update($image, $data);

        return $image;
    }

    /**
     * Proceso de elimianción de la Image en el proyecto.
     */
    public function deleteImage(Image $image): void
    {
        $this->imageRepository->delete($image);
    }

    /**
     * Proceso de restauración de la Image en el proyecto.
     */
    public function restoreImage(Image $image): void
    {
        $this->imageRepository->restore($image);
    }

    /**
     * Actualiza las etiquetas de una instancia Image.
     */
    public function updateLabels(Image $image, array $labelIds): Image
    {
        $this->activityService->setOldProperties($image->labels()->pluck('labels.name', 'labels.id')->toArray());

        $image = $this->imageRepository->syncLabels($image, $labelIds);
        $this->mediaImageService->syncMedia($image);

        $this->activityService->logActivity(
            logName: __('Images'),
            performedOn: $image,
            properties: $image->labels()->pluck('labels.name', 'labels.id')->toArray(),
            description: __('Labels updated.')
        );

        return $image;
    }

    /**
     * Descargar la imagen asociada al modelo
     */
    public function downloadImage(Image $image): StreamedResponse
    {
        $media = $image->getFirstMedia('*');

        // Verifica si el usuario tiene una foto de perfil
        if (!Storage::disk(config('jetstream.profile_photo_disk'))->exists($media->getPathRelativeToRoot())) {
            abort(404, __('The image does not exists.'));
        }

        return Storage::download($media->getPathRelativeToRoot(), $media->name);
    }
}
