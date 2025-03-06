<?php

namespace App\Livewire\Image;

use App\Livewire\Forms\ImageForm;
use App\Models\Label;
use App\Services\ImageService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
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
     * Catálogo de los permisos existentes en el sistema agroupados por su prefijo.
     */
    public array $availableLabels;

    /**
     * Reglas de validación para confirmar el wizard
     */
    protected function rules(): array
    {
        return [
            'imageForms' => [
                'required',
                'array',
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
                'id' => $image->id,
                'name' => $image->name,
                'description' => $image->description,
                'labelIds' => $image->labels->pluck('id')->toArray(),
            ];
        })->toArray();

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
    public function confirmWizard(ImageService $imageService)
    {
        $this->images->each(fn ($image) => Gate::authorize('update', $image));
        $this->validate();

        foreach ($this->imageForms as $index => $imageForm) {
            $this->form->fill($imageForm);
            $this->form->validate();

            $image = $imageService->updateImage($this->images[$index], $this->form->except('labelIds'));
            $imageService->updateLabels($image, $this->form->labelIds);
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
        $this->imageForms[$this->activeIndex] = $this->form->all();
    }
}
