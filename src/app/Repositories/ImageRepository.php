<?php

namespace App\Repositories;

use App\Models\Image;

class ImageRepository
{
    /**
     * Crea un registro Image en la base de datos
     */
    public function create(array $data): Image
    {
        return Image::create($data);
    }

    /**
     * Actualiza un registro Image en la base de datos
     */
    public function update(Image $image, array $data): Image
    {
        $image->update($data);

        return $image;
    }

    /**
     * Elimina un registro Image en la base de datos
     */
    public function delete(Image $image): void
    {
        $image->delete();
    }

    /**
     * Restaura un registro Image en la base de datos
     */
    public function restore(Image $image): void
    {
        $image->restore();
    }

    /**
     * Sincroniza las etiquetas de la imagen en BD.
     */
    public function syncLabels(Image $image, array $labelIds): Image
    {
        $image->labels()->sync($labelIds);

        return $image;
    }
}
