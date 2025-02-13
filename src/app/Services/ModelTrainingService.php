<?php

namespace App\Services;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ModelTrainingService
{
    /**
     * Descarga el modelo enlazado al modelo.
     */
    public function downloadModel(Media $modelMedia): BinaryFileResponse
    {
        return response()->download($modelMedia->getPath(), $modelMedia->file_name);
    }
}
