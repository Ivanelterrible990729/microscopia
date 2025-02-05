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
    public string $color;

    protected function rules()
    {
        return [
            'id' => 'numeric|exists:images,id',
            'name' => 'required|string|max:255|unique:labels',
            'description' => 'nullable|string',
            'color' => 'required|string|min:7|max:7|unique:labels',
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
            'id' => 'ID',
            'name' => __('Name'),
            'description' => __('Description'),
            'color' => __('Color'),
        ];
    }

    /**
     * Realiza la creación de la etiqueta.
     */
    public function store(): Label
    {
        $this->validateOnly('name');
        $this->validateOnly('description');
        $this->validateOnly('color');

        return Label::create($this->all());
    }

    /**
     * Actualiza el contenido de la etiqueta.
     */
    public function update(Label $label): Label
    {
        $this->validate();

        $label->update($this->all());
        return $label;
    }

    /**
     * Realiza la eliminación de la etiqueta
     */
    public function delete(Label $label): int
    {
        return $label->delete();
    }
}
