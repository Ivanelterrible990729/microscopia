<?php

namespace App\Livewire\Label;

use App\Livewire\Forms\LabelForm;
use App\Models\Label;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\Component;

class EditLabel extends Component
{
    /**
     * Label form
     */
    public LabelForm $form;

    /**
     *  Label de referencia a la cual editar.
     */
    public null|Label $label = null;

    public function render()
    {
        return view('livewire.label.edit-label');
    }

    #[On('edit-label')]
    public function loadLabel(string $labelId)
    {
        $this->label = Label::findOrFail($labelId);
        $this->form->fill([
            'id' => $this->label->id,
            'name' => $this->label->name,
            'description' => $this->label->description,
            'color' => $this->label->color,
        ]);

        $this->modal('modal-edit-label')->show();
    }

    public function updateLabel()
    {
        Gate::authorize('update', $this->label);

        $this->form->update($this->label);
        $this->label = null;
        $message = __('The label has been successfully updated.');

        $this->dispatch('label-updated', message: $message);
        $this->modal('modal-edit-label')->hide();
    }
}
