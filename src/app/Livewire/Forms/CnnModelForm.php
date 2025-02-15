<?php

namespace App\Livewire\Forms;

use App\Enums\Media\MediaEnum;
use App\Models\CnnModel;
use App\Rules\OnlyH5Files;
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
                new OnlyH5Files
            ],
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

    public function storeModel(): CnnModel
    {
        $this->validate();

        $cnnModel = CnnModel::create($this->except(['labelIds', 'file']));
        $cnnModel->labels()->sync($this->labelIds);

        if (isset($this->file)) {
            $cnnModel->addMedia($this->file)
                ->usingFileName(sanitizeFileName($this->file->getClientOriginalName()))
                ->usingName(sanitizeFileName($this->file->getClientOriginalName()))
                ->preservingOriginal(false)
                ->toMediaCollection(MediaEnum::CNN_Model->value);
        }

        return $cnnModel;
    }
}
