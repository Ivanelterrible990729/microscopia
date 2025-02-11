<?php

namespace App\Livewire\CnnModel;

use App\Livewire\Forms\CnnModelForm;
use App\Models\CnnModel;
use App\Models\Label;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateCnnModel extends Component
{
    use WithFileUploads;

    /**
     * Catálogo de etiquetas disponibles.
     */
    public array $availableLabels;

    /**
     * Form del modelo a crear
     */
    public CnnModelForm $form;

    /**
     * Bandera que determina si hay un archivo subido.
     */
    public $uploaded = false;

    public function mount()
    {
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
    }

    public function render()
    {
        return view('livewire.cnn-model.create-cnn-model');
    }

    /**
     * - Elimina referencia de file al archivo que se había subido con anterioridad
     * - Elimina el directorio temporal.
     */
    public function replaceFile()
    {
        $this->form->file = null;
        Storage::disk(config('filesystems.default'))->deleteDirectory('livewire/tmp');
    }

    public function createModel()
    {
        Gate::authorize('create', CnnModel::class);

        return redirect()->route('cnn-model.show', ['cnnModel' => $this->form->storeModel()])->with([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The model has been successfully stored.'),
            ]
        ]);
    }
}
