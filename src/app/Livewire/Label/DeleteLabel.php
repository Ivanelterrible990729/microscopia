<?php

namespace App\Livewire\Label;

use App\Models\Label;
use App\Services\LabelService;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\Component;

class DeleteLabel extends Component
{
    /**
     *  Label de referencia a la cual editar.
     */
    public null|Label $label = null;

    /**
     *  Numero de imagenes afectadas por la eliminacion de la etiqueta.
     */
    public int $numImagesAffected = 0;

    /**
     *  Numero de modelos afectados por la eliminacion de la etiqueta.
     */
    public int $numModelsAffected = 0;

    public function render()
    {
        return view('livewire.label.delete-label');
    }

    #[On('delete-label')]
    public function loadLabel(string $labelId)
    {
        $this->label = Label::findOrFail($labelId);
        $this->numImagesAffected = $this->label->images()->count();
        $this->numModelsAffected = $this->label->models()->count();

        $this->modal('modal-delete-label')->show();
    }

    public function deleteLabel(LabelService $labelService)
    {
        Gate::authorize('delete', $this->label);

        $labelService->deleteLabel($this->label);
        $this->label = null;

        $this->dispatch('label-deleted', message: __('The label has been successfully deleted.'));
        $this->modal('modal-delete-label')->hide();
    }
}
