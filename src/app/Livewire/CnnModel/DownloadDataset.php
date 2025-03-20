<?php

namespace App\Livewire\CnnModel;

use App\Models\CnnModel;
use App\Models\Label;
use Livewire\Attributes\On;
use Livewire\Component;

class DownloadDataset extends Component
{
    /**
     * Referencia al modelo el cual entrenar.
     */
    public CnnModel $cnnModel;

    /**
     * Form para realizar el entrenamiento
     */
    public array $form;

    /**
     * Catálogo de modelos disponibles
     */
    public array $availableLabels = [];

    protected function rules()
    {
        return [
            'form.selected_labels' => 'required|array|min:1',
            'form.all_images' => 'required|boolean',
            'form.crop_images' => 'required|boolean',
            'form.data_augmentation' => 'required|boolean',
            'form.images_limit' => 'required_if:form.all_images|numeric|min:1',
        ];
    }

    protected function validationAttributes()
    {
        return [
            'form.selected_labels' => __('Training labels'),
            'form.all_images' => __('Download all images'),
            'form.crop_images' => __('Crop images'),
            'form.data_augmentation' => __('Data augmentation'),
            'form.images_limit' => __('Maximum number of images'),
        ];
    }

    public function mount(CnnModel $cnnModel)
    {
        $this->availableLabels = Label::withCount('images')
        ->orderBy('name')
        ->get()
        ->map(function($label) {
            return [
                'id' => $label->id,
                'name' => $label->name,
                'color' => $label->color,
                'images_count' => $label->images_count,
            ];
        })->toArray();

        $this->form = [
            'selected_labels' => $cnnModel->labels->pluck('id')->toArray(),
            'all_images' => false,
            'crop_images' => false,
            'data_augmentation' => false,
            'images_limit' => 0,
        ];
    }

    public function render()
    {
        return view('livewire.cnn-model.download-dataset');
    }

    /**
     * Esta función se utiliza para recalcular el numero mínimo de imágenes
     * que se utilizará por cada etiqueta en el entrenamiento.
     * Se utiliza en el front con fines informativos y actualiza $this->form['images-limit'].
     */
    public function uploadMinImages(): int
    {
        $selectedImagesCounts = array_map(
            fn($id) => $this->availableLabels[array_search($id, array_column($this->availableLabels, 'id'))]['images_count'] ?? PHP_INT_MAX,
            $this->form['selected_labels']
        );

        $minImagesCount = !empty($selectedImagesCounts) ? min($selectedImagesCounts) : null;
        $this->form['images_limit'] = ($minImagesCount ?? 0);

        return $this->form['images_limit'];
    }

    /**
     * Descarga el dataset para entrenar el modelo según las etiquetas seleccionadas
     */
    public function downloadDataset()
    {
        $this->validate();
    }

    /**
     * Refrezca el contenido del modelo para actualizarlo en la vista.
     */
    #[On('refresh-model')]
    public function refreshModel()
    {
        $this->cnnModel->refresh();
    }
}
