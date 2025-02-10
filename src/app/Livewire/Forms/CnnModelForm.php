<?php

namespace App\Livewire\Forms;

use App\Models\CnnModel;
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
    public null|UploadedFile $file;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:cnn_models,name,' . (isset($this->id) ? $this->id : ''),
            'labelIds' => 'required|array|min:1',
            'labelIds.*' => 'numeric|exists:cnn_models,id',
            'file' => 'nullable|file|mimes:h5|max:' . config('max-file-size.models'),
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

        $cnnModel = CnnModel::create($this->except('labelIds'));
        $cnnModel->labels()->sync($this->labelIds);

        // TODO: AddMedia

        return $cnnModel;
    }
}
