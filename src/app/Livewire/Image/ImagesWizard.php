<?php

namespace App\Livewire\Image;

use Illuminate\Support\Collection;
use Livewire\Component;

class ImagesWizard extends Component
{
    /**
     * Colección de las imágenes para realizar el actualizado.
     */
    public Collection $images;

    /**
     * Formularios de las imagenes.
     */
    public array $formImages;

    /**
     * Formulario activo
     */
    public array $activeForm;

    /**
     * Índice que hace referencia al formulario activo
     */
    public int $activeIndex;

    public function mount(Collection $images)
    {
        $this->images = $images;

        $this->formImages = $images->map(function($image) {
            return [
                'confirmed' => false,
                'id' => $image->id,
                'name' => $image->name,
                'description' => null,
                'labels' => $image->labels,
            ];
        })->toArray();

        $this->activeIndex = 0;
        $this->activeForm = $this->formImages[$this->activeIndex];
    }

    public function render()
    {
        return view('livewire.image.images-wizard');
    }
}
