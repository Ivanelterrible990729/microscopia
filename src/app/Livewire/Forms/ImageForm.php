<?php

namespace App\Livewire\Forms;

use App\Models\Image;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ImageForm extends Form
{
    /**
     * Bandera de confirmación únicamente para ImagesWizard.
     */
    public bool $reviewed;

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
    public string $description;

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

    /**
     * Actualiza todos los campos de la imágen.
     */
    public function update(Image $image, bool $validate = true): Image
    {
        if ($validate) {
            $this->validateForm();
        }

        $image->update($this->except(['labelIds']));

        return $this->updateLabels($image, $this->labelIds, validate: false);
    }

    /**
     * Actualiza únicamente las etiquetas de la imágen.
     */
    public function updateLabels(Image $image, array $labelIds, bool $validate = true): Image
    {
        if ($validate) {
            $this->validate(rules: [
                'labelIds' => 'nullable|array',
                'labelIds.*' => 'numeric|exists:labels,id',
            ], attributes: [
                'labelIds' => __('Labels'),
                'labelIds.*' => __('Label'),
            ]);
        }

        $image->labels()->sync($labelIds);
        return $image;
    }

    /**
     * Realiza únicamente la validación del Form.
     */
    public function validateForm(): void
    {
        $this->validate();
    }
}
