<?php

namespace App\Services;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ModelTrainingService
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
    public function downloadModel(Media $modelMedia): BinaryFileResponse
    {
        return response()->download($modelMedia->getPath(), $modelMedia->file_name);
    }
}
