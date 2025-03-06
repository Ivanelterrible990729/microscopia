<?php

namespace App\Repositories;

use App\Enums\Media\MediaEnum;
use App\Models\CnnModel;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CnnModelRepository
{
    /**
     * Crea un registro CnnModel en la base de datos
     */
    public function create(array $data): CnnModel
    {
        return CnnModel::create($data);
    }

    /**
     * Actualiza un registro CnnModel en la base de datos
     */
    public function update(CnnModel $cnnModel, array $data): CnnModel
    {
        $cnnModel->update($data);
        return $cnnModel;
    }

    /**
     * Elimina un registro CnnModel en la base de datos
     */
    public function delete(CnnModel $cnnModel): void
    {
        $cnnModel->delete();
    }

    /**
     * Sincroniza Labels con CnnModel en BD.
     */
    public function syncLabels(CnnModel $cnnModel, array $labelIds): CnnModel
    {
        $cnnModel->labels()->sync($labelIds);

        return $cnnModel;
    }

    /**
     * Enlaza modelo Media con Cnn Model en BD.
     */
    public function addModelMedia(CnnModel $cnnModel, UploadedFile $file): Media
    {
        $cnnModel->addMedia($file)
            ->usingFileName(sanitizeFileName($file->getClientOriginalName()))
            ->usingName(sanitizeFileName($file->getClientOriginalName()))
            ->preservingOriginal(false)
            ->toMediaCollection(MediaEnum::CNN_Model->value);

        return $cnnModel->getFirstMedia(MediaEnum::CNN_Model->value);
    }

    /**
     * Reemplaza modelo Media con Cnn Model en BD.
     */
    public function replaceModelMedia(CnnModel $cnnModel, UploadedFile $file): Media
    {
        $cnnModel->media()->get()->each->delete();

        $cnnModel->addMedia($file)
            ->usingFileName(sanitizeFileName($file->getClientOriginalName()))
            ->usingName(sanitizeFileName($file->getClientOriginalName()))
            ->preservingOriginal(false)
            ->toMediaCollection(MediaEnum::CNN_Model->value);

        return $cnnModel->getFirstMedia(MediaEnum::CNN_Model->value);
    }
}
