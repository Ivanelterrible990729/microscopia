<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class TrainCnnModelForm extends Form
{
    /**
     *  Path del modelo al cual realizar el entrenamiento.
     */
    public string $modelPath;

    /**
     *  Etiquetas seleccionadas para el entrenamiento.
     */
    public array $selectedLabels;

    /**
     * Porción a utilizar para el validation-set en el entrenamiento.
     */
    public string $validationPortion = '0.2';

    /**
     * Máxima cantidad de imágenes disponible para mantener un entrenamiento equilibrado.
     */
    public int $imagesLimit = 0;

    protected function rules()
    {
        return [
            'modelPath' => 'required|string',
            'selectedLabels' => 'required|array|min:1',
            'validationPortion' => 'required|decimal:1,2',
            'imagesLimit' => 'required|numeric|min:1',
        ];
    }

    protected function validationAttributes()
    {
        return [
            'modelPath' => __('Available models'),
            'selectedLabels' => __('Training labels'),
            'validationPortion' => __('Validation portion'),
            'imagesLimit' => __('Maximum number of images per label'),
        ];
    }
}
