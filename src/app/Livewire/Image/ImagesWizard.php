<?php

namespace App\Livewire\Image;

use App\Livewire\Forms\ImageForm;
use App\Rules\ReviewedImages;
use Illuminate\Support\Collection;
use Livewire\Component;

class ImagesWizard extends Component
{
    /**
     * Image Form - activeForm.
     */
    public ImageForm $form;

    /**
     * Colección de las imágenes para realizar el actualizado.
     */
    public Collection $images;

    /**
     * Formularios de las imagenes.
     */
    public array $imageForms;

    /**
     * Índice para navegar entre imageForms.
     */
    public int $activeIndex;

    /**
     *  Último índice para controlar la navegación del wizard.
     */
    public int $lastIndex;

    /**
     * Reglas de validación para confirmar el wizard
     */
    protected function rules(): array
    {
        return [
            'imageForms' => [
                'required',
                'array',
                new ReviewedImages,
            ],
        ];
    }

    protected function messages()
    {
        return [
            'imageForms' => __('Please, review all the images before confirming the wizard'),
        ];
    }

    public function mount(Collection $images): void
    {
        $this->images = $images;

        $this->imageForms = $images->map(function($image) {
            return [
                'reviewed' => false,
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
     * Verifica que todas las imágenes hayan sido revisadas.
     * Actualiza cada una de las imágenes revisadas.
     * Redirige a image.index.
     */
    public function confirmWizard()
    {
        $this->validate();

        foreach ($this->imageForms as $index => $imageForm) {
            $this->form->fill($imageForm);
            $this->form->update($this->images[$index], validate: false);
            $this->images[$index]->refresh();
        }

        return redirect()->route('image.index')->with([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('Wizard successfully completed')
            ]
        ]);
    }

    /**
     * Guardar, incrementar y asignar activeForm.
     */
    public function next(): void
    {
        $this->saveActiveForm();
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

        $this->saveActiveForm();
        $this->activeIndex--;
        $this->setActiveForm();
    }

    /**
     * Ubicar al index indicado.
     */
    public function setActiveIndex($index): void
    {
        $this->saveActiveForm();
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

        $this->form->fill($this->imageForms[$this->activeIndex]);
    }

    /**
     * Guarda activeForm siempre y cuando se trate de un índice válido.
     */
    private function saveActiveForm(): void
    {
        if ($this->activeIndex > $this->lastIndex) {
            return;
        }

        $this->form->validate();
        $this->form->reviewed = true;
        $this->imageForms[$this->activeIndex] = $this->form->all();
    }
}
