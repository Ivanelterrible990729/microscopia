<?php

namespace App\Livewire\Image;

use App\Livewire\Forms\ImageForm;
use App\Models\Image;
use App\Models\Label;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class EditLabelsImage extends Component
{
    /**
     *  Image Form
     */
    public ImageForm $form;

    /**
     *  Imagen de referencia a la cual agregar la etiqueta.
     */
    public Image $image;

    /**
     *  Determina si se almacena en base de datos.
     */
    public bool $store = false;

    /**
     *  Determina si se realiza redirección o envío de eventos.
     */
    public bool $redirectToShow = false;

    /**
     * Etiquetas seleccionadas
     */
    public Collection $selectedLabels;

    /**
     * Catálogo de los permisos existentes en el sistema agroupados por su prefijo.
     */
    #[Computed]
    public function availableLabels(): Collection
    {
        return Label::query()
            ->orderBy('name')
            ->select([
                'id',
                'name',
                'color',
                'number_images'
            ])->get()
            ->map(function($label) {
                return [
                    'id' => $label->id,
                    'name' => $label->name,
                ];
            });
    }

    public function mount(Image $image)
    {
        $this->image = $image;
        $this->selectedLabels = $image->labels->map(function($label) {
            return [
                'id' => $label->id,
                'name' => $label->name,
            ];
        });
    }

    public function render()
    {
        return view('livewire.image.edit-labels-image');
    }

    /**
     * - Realiza conversión de selectedLabels a labelIds
     *
     */
    public function addLabel()
    {
        $this->form->labelIds = array_column($this->selectedLabels->toArray(), 'id');

        if ($this->store) {
            $this->form->updateLabels($this->image, validate: true);
        } else {
            $this->form->validateOnly('form.labelIds');
            $this->form->validateOnly('form.labelIds.*');
        }

        $this->selectedLabels = $this->image->labels->map(function($label) {
            return [
                'id' => $label->id,
                'name' => $label->name,
            ];
        });

        $this->dispatch('labels-updated', imageId: $this->image->id, labelIds: $this->form->labelIds);
        $this->modal('modal-add-labels-image')->hide();

        if ($this->redirectToShow) {
            return redirect()->route('image.show', $this->image)->with([
                'alert' => [
                    'variant' => 'soft-primary',
                    'icon' => 'check-circle',
                    'message' => __('The image labels were successfully updated.')
                ]
            ]);
        } else {
            $this->toast(title: __('Success'), message: __('The image labels were successfully updated.'))->success();
        }
    }
}
