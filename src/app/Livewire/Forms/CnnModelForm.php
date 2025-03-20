<?php

namespace App\Livewire\Forms;

use App\Rules\OnlyKerasFiles;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CnnModelForm extends Form
{
    /**
     * Id del modelo CNN
     */
    public null|int $id = null;

    /**
     * Nombre del modelo CNN
     */
    public string $name = '';

    /**
     * Etiquetas del modelo CNN
     *
     * @var array<int>
     */
    public array $labelIds = [];

    /**
     * Archivo relacionado al modelo creado.
     */
    public null|UploadedFile $file = null;

    /**
     * Nombre del archivo (Solo para edición)
     */
    public null|string $filename = null;

    /**
     * parámetros utilizados para las métricas del modelo.
     */
    public null|string $accuracy = null;
    public null|string $loss = null;
    public null|string $val_accuracy = null;
    public null|string $val_loss = null;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:cnn_models,name,' . (isset($this->id) ? $this->id : ''),
            'labelIds' => 'required|array|min:1',
            'labelIds.*' => 'numeric|exists:labels,id',
            'file' => [
                'nullable',
                'file',
                'max:' . config('max-file-size.models'),
                new OnlyKerasFiles
            ],
            'accuracy' => 'nullable|decimal:1,4',
            'val_accuracy' => 'nullable|decimal:1,4',
            'loss' => 'nullable|decimal:1,4',
            'val_loss' => 'nullable|decimal:1,4',
        ];
    }

    protected function messages()
    {
        return [
            'labelIds.*.exists' => __('Una de las etiquetas seleccionadas no existe en la base de datos.'),
            'file.max' => __('El archivo debe pesar menos de' . config('file-max-size.models_desc')),
        ];
    }

    protected function validationAttributes()
    {
        return [
            'id' => 'ID',
            'name' => __('Name'),
            'labelIds' => __('Labels'),
            'labelIds.*' => __('Label'),
            'file' => __('File'),
        ];
    }
}
