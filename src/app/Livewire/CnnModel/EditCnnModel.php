<?php

namespace App\Livewire\CnnModel;

use App\Livewire\Forms\CnnModelForm;
use App\Models\CnnModel;
use App\Models\Label;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class EditCnnModel extends Component
{
    use WithFileUploads;

    /**
     * Catálogo de etiquetas disponibles.
     */
    public array $availableLabels;

    /**
     * Form del modelo a actualizar
     */
    public CnnModelForm $form;

    /**
     * Referencia del modelo a actualizar
     */
    public CnnModel $cnnModel;

    /**
     * Bandera que determina si hay un archivo subido.
     */
    public $uploaded = false;

    public function mount(CnnModel $cnnModel)
    {
        $this->cnnModel = $cnnModel;

        $this->availableLabels = Label::query()
            ->orderBy('name')
            ->get()
            ->map(function($label) {
                return [
                    'id' => $label->id,
                    'name' => $label->name,
                    'color' => $label->color,
                ];
            })->toArray();

        $this->form->fill([
            'id' => $this->cnnModel->id,
            'name' => $this->cnnModel->name,
            'labelIds' => $this->cnnModel->labels->pluck('id')->toArray(),
        ]);

        if ($this->cnnModel->hasMedia('*')) {
            $this->uploaded = true;
            $this->form->filename = $this->cnnModel->getFirstMedia('*')->file_name;
        }
    }

    public function render()
    {
        return view('livewire.cnn-model.edit-cnn-model');
    }

    /**
     * - Elimina referencia de file al archivo que se había subido con anterioridad
     * - Elimina el directorio temporal.
     */
    public function replaceFile()
    {
        $this->form->file = $this->form->filename = null;
        Storage::disk(config('filesystems.default'))->deleteDirectory('livewire/tmp');
    }

    public function updateModel()
    {
        Gate::authorize('update', $this->cnnModel);

        return redirect()->route('cnn-model.show', ['cnnModel' => $this->form->updateModel(cnnModel: $this->cnnModel)])->with([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The model has been successfully updated.'),
            ]
        ]);
    }
}
