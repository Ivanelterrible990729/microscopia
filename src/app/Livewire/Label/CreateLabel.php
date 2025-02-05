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

    public function mount()
    {
        $this->form->color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }

    public function render()
    {
        return view('livewire.label.create-label');
    }

    public function storeLabel()
    {
        Gate::authorize('create', Label::class);

        $this->form->store();
        $message = __('The label has been successfully stored.');

        $this->dispatch('label-created', message: $message);
        $this->modal('modal-create-label')->hide();
    }
}
