<?php

namespace App\Livewire\Forms;

use App\Models\Image;
use App\Services\MediaImageService;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ImageForm extends Form
{
    /**
     * Id de la imágen
     */
    public int $id;

    /**
     * Nombre de la imágen
     */
    public string $name;

    /**
     * Descripción de la imágen
     */
    public null|string $description;

    /**
     * Etiquetas de la imágen
     *
     * @var array<int>
     */
    public array $labelIds;

    protected function rules()
    {
        return [
            'id' => 'numeric|exists:images,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'labelIds' => 'nullable|array',
            'labelIds.*' => 'numeric|exists:labels,id',
        ];
    }

    protected function messages()
    {
        return [
            'labelIds.*.exists' => __('Una de las etiquetas seleccionadas no existe en la base de datos.'),
        ];
    }

    protected function validationAttributes()
    {
        return [
            'id' => 'ID',
            'name' => __('Name'),
            'description' => __('Description'),
            'labelIds' => __('Labels'),
            'labelIds.*' => __('Label'),
        ];
    }
}
