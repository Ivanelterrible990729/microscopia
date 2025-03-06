<?php

namespace App\Services;

use App\Contracts\Services\ActivityInterface;
use App\Models\CnnModel;
use App\Repositories\CnnModelRepository;
use Illuminate\Http\UploadedFile;

class CnnModelService
{
    /**
     * Activitylog está registrado en los eventos created, updated & deleted en CnnModel.php
     */
    public function __construct(
        protected CnnModelRepository $cnnModelRepository,
        protected ActivityInterface $activityService
    ) {}

    /**
     * Proceso de registro de un CnnModel.
     */
    public function createCnnModel(array $data): CnnModel
    {
        $cnnModel = $this->cnnModelRepository->create($data);

        return $cnnModel;
    }

    /**
     * Proceso de actualización de un CnnModel.
     */
    public function udpateCnnModel(CnnModel $cnnModel, array $data): CnnModel
    {
        $cnnModel = $this->cnnModelRepository->update($cnnModel, $data);

        return $cnnModel;
    }

    /**
     * Proceso de eliminación de un CnnModel.
     */
    public function deleteCnnModel(CnnModel $cnnModel): void
    {
        $this->cnnModelRepository->delete($cnnModel);
    }

    /**
     * Actualiza las etiquetas de una instancia CnnModel.
     */
    public function updateLabels(CnnModel $cnnModel, array $labelIds): CnnModel
    {
        $this->activityService->setOldProperties($cnnModel->labels()->pluck('labels.name', 'labels.id')->toArray());

        $cnnModel = $this->cnnModelRepository->syncLabels($cnnModel, $labelIds);

        $this->activityService->logActivity(
            logName: __('CNN Models'),
            performedOn: $cnnModel,
            properties: $cnnModel->labels()->pluck('labels.name', 'labels.id')->toArray(),
            description: __('Labels updated.')
        );

        return $cnnModel;
    }

    /**
     * Enlaza el archivo del modelo a la instacia CnnModel.
     */
    public function addModelMedia(CnnModel $cnnModel, UploadedFile $file): void
    {
        $media = $this->cnnModelRepository->addModelMedia($cnnModel, $file);

        $this->activityService->logActivity(
            logName: __('CNN Models'),
            performedOn: $cnnModel,
            properties: $media->getAttributes(),
            description: __('File uploaded.')
        );
    }

    /**
     * Remplaza el archivo del modelo a la instacia CnnModel.
     */
    public function replaceModelMedia(CnnModel $cnnModel, UploadedFile $file): void
    {
        $media = $this->cnnModelRepository->replaceModelMedia($cnnModel, $file);

        $this->activityService->logActivity(
            logName: __('CNN Models'),
            performedOn: $cnnModel,
            properties: $media->getAttributes(),
            description: __('File replaced.')
        );
    }
}
