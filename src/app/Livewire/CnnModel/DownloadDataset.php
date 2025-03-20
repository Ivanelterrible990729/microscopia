<?php

namespace App\Livewire\CnnModel;

use App\Livewire\Forms\DownloadDatasetForm;
use App\Models\CnnModel;
use App\Models\Label;
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
    public DownloadDatasetForm $form;

    /**
     * Catálogo de modelos disponibles
     */
    public array $availableLabels = [];

    /**
     * Pasos a realizar durante la descarga de imágenes.
     */
    public array $steps = [];

    /**
     * Verifica que el componente esté en fase de descarga.
     */
    public bool $onDownload = false;

    public function mount(CnnModel $cnnModel)
    {
        $this->cnnModel = $cnnModel;

        $this->defineSteps();
        $this->availableLabels = $this->getAvailableLabels();

        $this->form->selectedLabels = $cnnModel->labels->pluck('id')->toArray();
        $this->form->allImages = false;
        $this->form->dataAugmentation = false;
        $this->form->imagesLimit = $this->uploadMinImages();
    }

    /**
     * Pasos requeridos para llevar a cabo la descarga.
     */
    private function defineSteps()
    {
        $this->steps = [
            [
                'method' => 'createEnvironment',
                'milliseconds' => 3000,
                'next_method' => 'imageCrop',
                'title' => __('Training environment'),
                'description' => __("Creating a new directory to allocate the dataset."),
                'status' => null,
                'result' => null,
            ],
            [
                'method' => 'imageCrop',
                'milliseconds' => 3000,
                'next_method' => 'imageAugmentation',
                'title' => __('Image cropping'),
                'description' => __("This process is necessary to perform the image augmentation."),
                'status' => null,
                'result' => null,
            ],
            [
                'method' => 'imageAugmentation',
                'milliseconds' => 3000,
                'next_method' => 'cnnModelTraining',
                'title' => __('Image augmentation'),
                'description' => __("Generating new images to enrich the dataset."),
                'status' => null,
                'result' => null,
            ],
            [
                'method' => 'createZipFiles',
                'milliseconds' => 3000,
                'next_method' => 'finish',
                'title' => __('Create zip files'),
                'description' => __('Generating zip files for downloading the dataset.'),
                'status' => null,
                'result' => null,
            ]
        ];
    }

    /**
     * Obtiene las etiquetas disponibles para realizar la descarga.
     */
    private function getAvailableLabels(): array
    {
        return Label::withCount('images')
            ->orderBy('name')
            ->get()
            ->map(function($label) {
                return [
                    'id' => $label->id,
                    'name' => $label->name,
                    'folder_name' => $label->folder_name,
                    'color' => $label->color,
                    'images_count' => $label->images_count,
                ];
        })->toArray();
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
            $this->form->selectedLabels
        );

        $minImagesCount = !empty($selectedImagesCounts) ? min($selectedImagesCounts) : null;
        $this->form->imagesLimit = ($minImagesCount ?? 0);

        return $this->form->imagesLimit;
    }

    public function render()
    {
        return view('livewire.cnn-model.download-dataset');
    }

    /**
     * Descarga el dataset para entrenar el modelo según las etiquetas seleccionadas
     */
    public function downloadDataset()
    {
        $this->validate();
    }
}
