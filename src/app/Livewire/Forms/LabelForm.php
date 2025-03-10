<?php

namespace App\Livewire\Forms;

use App\Models\Label;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LabelForm extends Form
{
    /**
     * Id de la etiqueta
     */
    public null|int $id = null;

    /**
     * Nombre de la etiqueta
     */
    public string $name = '';

    /**
     * Descripción de la etiqueta
     */
    public null|string $description = null;

    /**
     * Color de la etiqueta
     */
    public string $color = '#FFFFFF';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:labels,name,' . (isset($this->id) ? $this->id : ''),
            'description' => 'nullable|string',
            'color' => 'required|string|min:7|max:7|unique:labels,color,' . (isset($this->id) ? $this->id : ''),
        ];
    }

    protected function messages()
    {
        return [

        ];
    }

    protected function validationAttributes()
    {
        return [
            'name' => __('Name'),
            'description' => __('Description'),
            'color' => __('Color'),
        ];
    }
}
