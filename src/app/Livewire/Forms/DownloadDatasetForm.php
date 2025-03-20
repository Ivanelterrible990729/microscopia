<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class DownloadDatasetForm extends Form
{
    /**
     *  Etiquetas seleccionadas para el entrenamiento.
     */
    public array $selectedLabels = [];

    /**
     * Bandera que indica si hacerle caso a imagesLimit o no.
     */
    public bool $allImages = false;

    /**
     * Bandera que indica si se performará el data augmentation.
     */
    public bool $dataAugmentation = false;

    /**
     * Máxima cantidad de imágenes disponible para mantener un entrenamiento equilibrado.
     */
    public int $imagesLimit = 0;

    protected function rules()
    {
        return [
            'selectedLabels' => 'required|array|min:1',
            'allImages' => 'required|boolean',
            'dataAugmentation' => 'required|boolean',
            'imagesLimit' => 'required_if:form.all_images|numeric|min:1',
        ];
    }

    protected function validationAttributes()
    {
        return [
            'selectedLabels' => __('Training labels'),
            'allImages' => __('Download all images'),
            'dataAugmentation' => __('Data augmentation'),
            'imagesLimit' => __('Maximum number of images'),
        ];
    }
}
