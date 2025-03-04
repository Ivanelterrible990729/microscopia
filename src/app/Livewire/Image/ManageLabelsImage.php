<?php

namespace App\Livewire\Image;

use App\Livewire\Forms\ImageForm;
use App\Models\Image;
use App\Models\Label;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\Component;

class ManageLabelsImage extends Component
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
     * Catálogo de etiquetas disponibles.
     */
    public array $availableLabels;

    public function mount(Image $image)
    {
        $this->image = $image;
        $this->form->labelIds = $this->image->labels->pluck('id')->toArray();

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
        return view('livewire.image.manage-labels-image');
    }

    #[On('manage-labels-image')]
    public function loadImage(string $imageId)
    {
        $this->image = Image::findOrFail($imageId);
        $this->image->load('labels');
        $this->form->labelIds = $this->image->labels->pluck('id')->toArray();

        $this->modal('modal-manage-labels-image')->show();
    }

    /**
     * Realiza la edición de etiquetas.
     */
    public function editLabels()
    {
        Gate::authorize('manageLabels', $this->image);

        $this->form->updateLabels($this->image, validate: true);
        $this->modal('modal-manage-labels-image')->hide();

        return redirect()->route('image.show', $this->image)->with([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The image labels were successfully updated.')
            ]
        ]);
    }
}
