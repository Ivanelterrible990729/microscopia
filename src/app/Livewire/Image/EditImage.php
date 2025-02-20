<?php

namespace App\Livewire\Image;

use App\Livewire\Forms\ImageForm;
use App\Models\Image;
use App\Models\Label;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class EditImage extends Component
{
    /**
     * Image Form - activeForm.
     */
    public ImageForm $form;

    /**
     * Referencia de la imagen a editar
     */
    public Image $image;

    /**
     * Catálogo de los permisos existentes en el sistema agroupados por su prefijo.
     */
    public array $availableLabels;

    public function mount(Image $image)
    {
        $this->image = $image;

        $this->form->fill([
            'id' => $image->id,
            'name' => $image->name,
            'description' => $image->description,
            'labelIds' => $image->labels->pluck('id')->toArray(),
        ]);

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
        return view('livewire.image.edit-image');
    }

    public function updateImage()
    {
        Gate::authorize('update', $this->image);

        $this->form->update($this->image);

        return redirect()->route('image.show', $this->image)->with([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The image has been successfully updated.')
            ]
        ]);
    }
}
