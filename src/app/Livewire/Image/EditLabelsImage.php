<?php

namespace App\Livewire\Image;

use App\Livewire\Forms\ImageForm;
use App\Livewire\Listados\ImagesTable;
use App\Models\Image;
use App\Models\Label;
use Livewire\Attributes\On;
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
    public Image|null $image;

    /**
     *  Determina si se realiza redirección.
     */
    public string|null $redirectToRoute = null;

    /**
     * Catálogo de etiquetas disponibles.
     */
    public array $availableLabels;

    public function mount()
    {
        $image = request('image', null);
        if (isset($image)) {
            $this->image = $image;
            $this->form->labelIds = $this->image->labels->pluck('id')->toArray();
            $this->redirectToRoute = route('image.show', $image);
        } else {
            $this->image = null;
            $this->form->labelIds = [];
            $this->redirectToRoute = null;
        }

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
        return view('livewire.image.edit-labels-image');
    }

    #[On('edit-labels-image')]
    public function loadImage(string $imageId)
    {
        $this->image = Image::findOrFail($imageId);
        $this->image->load('labels');
        $this->form->labelIds = $this->image->labels->pluck('id')->toArray();

        $this->modal('modal-edit-labels')->show();
    }

    /**
     * Realiza la edición de etiquetas.
     */
    public function editLabels()
    {
        $this->form->updateLabels($this->image, validate: true);
        $this->modal('modal-edit-labels')->hide();

        if (isset($this->redirectToRoute)) {
            return redirect()->route('image.show', $this->image)->with([
                'alert' => [
                    'variant' => 'soft-primary',
                    'icon' => 'check-circle',
                    'message' => __('The image labels were successfully updated.')
                ]
            ]);
        } else {
            $this->dispatch('image-labels-updated');
        }
    }

    #[On('label-created')]
    public function refreshAvailableLabels()
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
}
