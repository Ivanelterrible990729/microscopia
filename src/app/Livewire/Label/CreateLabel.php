<?php

namespace App\Livewire\Label;

use App\Livewire\Forms\LabelForm;
use App\Models\Label;
use App\Services\LabelService;
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

    public function storeLabel(LabelService $labelService)
    {
        Gate::authorize('create', Label::class);
        $this->validate();

        $labelService->createLabel($this->form->all());
        $this->form->reset();

        $this->dispatch('label-created', message:  __('The label has been successfully stored.'));
        $this->modal('modal-create-label')->hide();
    }
}
