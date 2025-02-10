<?php

namespace App\Livewire\CnnModel;

use App\Livewire\Forms\CnnModelForm;
use App\Models\Label;
use Livewire\Component;

class CreateCnnModel extends Component
{
    /**
     * Catálogo de etiquetas disponibles.
     */
    public array $availableLabels;

    /**
     * Form del modelo a crear
     */
    public CnnModelForm $form;

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

    public function createModel()
    {
        return redirect()->route('cnn-model.show', ['cnnModel' => $this->form->storeModel()])->with([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The model was created succesfully.'),
            ]
        ]);
    }
}
