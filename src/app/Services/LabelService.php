<?php

namespace App\Services;

use App\Models\Label;
use App\Repositories\LabelRepository;

class LabelService
{
    /**
     * Activitylog está registrado en los eventos created, updated & deleted en Label.php
     */
    public function __construct(
        protected LabelRepository $labelRepository,
    ) {}

    /**
     * Proceso de registro de una etiqueta.
     */
    public function createLabel(array $data): Label
    {
        return $this->labelRepository->create($data);
    }

    /**
     * Proceso de actualización de una etiqueta.
     */
    public function updateLabel(Label $label, array $data): Label
    {
        $label = $this->labelRepository->update($label, $data);
        return $label;
    }

    /**
     * Proceso de eliminación de una etiqueta.
     */
    public function deleteLabel(Label $label): void
    {
        $this->labelRepository->delete($label);
    }
}
