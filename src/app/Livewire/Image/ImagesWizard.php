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
    public array $imageForms;

    /**
     * Formulario activo
     */
    public array|null $activeForm;

    /**
     * Índice para navegar entre imageForms.
     */
    public int $activeIndex;

    /**
     *  Último índice para controlar la navegación del wizard.
     */
    public int $lastIndex;

    public function mount(Collection $images): void
    {
        $this->images = $images;

        $this->imageForms = $images->map(function($image) {
            return [
                'confirmed' => false,
                'id' => $image->id,
                'name' => $image->name,
                'description' => $image->description,
                'labelIds' => $image->labels->pluck('id')->toArray(),
            ];
        })->toArray();

        $this->activeIndex = 0;
        $this->lastIndex = count($this->imageForms) - 1;

        $this->setActiveForm();
    }

    public function render()
    {
        return view('livewire.image.images-wizard');
    }

    /**
     * Guardar, incrementar y asignar activeForm.
     */
    public function next(): void
    {
        $this->saveImageForm();
        $this->activeIndex++;
        $this->setActiveForm();
    }

    /**
     * Guardar, decrementar y asignar activeForm.
     */
    public function previous(): void
    {
        if ($this->activeIndex == 0) {
            return;
        }

        $this->saveImageForm();
        $this->activeIndex--;
        $this->setActiveForm();
    }

    /**
     * Ubicar al index indicado.
     */
    public function setActiveIndex($index): void
    {
        $this->saveImageForm();
        $this->activeIndex = $index;
        $this->setActiveForm();
    }

    /**
     * Inicializa activeForm siempre y cuando se trate de un índice válido.
     */
    private function setActiveForm(): void
    {
        if ($this->activeIndex > $this->lastIndex) {
            return;
        }

        $this->activeForm = $this->imageForms[$this->activeIndex];
    }

    /**
     * Guarda activeForm siempre y cuando se trate de un índice válido.
     */
    private function saveImageForm(): void
    {
        if ($this->activeIndex > $this->lastIndex) {
            return;
        }

        $this->activeForm['confirmed'] = true;
        $this->imageForms[$this->activeIndex] = $this->activeForm;
    }
}
