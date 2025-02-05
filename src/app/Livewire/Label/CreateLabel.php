<?php

namespace App\Livewire\Label;

use App\Livewire\Forms\LabelForm;
use App\Models\Label;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class CreateLabel extends Component
{
    /**
     * Image Form - activeForm.
     */
    public LabelForm $form;

    public function render()
    {
        return view('livewire.label.create-label');
    }

    public function storeLabel()
    {
        Gate::authorize('create', Label::class);

        $this->form->store();
        $this->form->reset();
        $message = __('The label has been successfully stored.');

        $this->dispatch('label-created', message: $message);
        $this->modal('modal-create-label')->hide();
    }
}
