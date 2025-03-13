<?php

namespace App\Livewire\Image;

use App\Enums\Media\MediaEnum;
use App\Models\CnnModel;
use App\Models\Image;
use App\Services\PythonService;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class ManageImageReport extends Component
{
    /**
     * IDs de las imagenes a analizar.
     */
    public array $imageIds = [];

    /**
     * Predicciones correspondientes a los IDs de las imágenes a analizar.
     */
    public array $predictions = [];

    /**
     * Almacena el mmodelo seleccionado para realizar las predicciones del informe.
     */
    public string $modelPath;

    /**
     * Id del modelo a utilizar para la predicciones y el informe.
     */
    public string $modelId;

    /**
     * Catálogo de modelos disponibles para realizar el reporte.
     */
    #[Computed]
    public function availableModels(): array
    {
        $modelsMedia = CnnModel::whereHas('media')
            ->with('media')
            ->get()
            ->map(function($cnnModel) {
                return [
                    $cnnModel->getFirstMedia(MediaEnum::CNN_Model->value)->getPath() => $cnnModel->name,
                ];
            })->toArray();

        return array_reduce($modelsMedia, function (null|array $carry, array $item) {
            return is_null($carry) ? $item : $carry += $item;
        });
    }

    protected function rules()
    {
        return [
            'imageIds' => 'array|min:1',
            'imageIds.*' => 'numeric|exists:images,id',
            'modelPath' => 'required|string'
        ];
    }

    protected function messages()
    {
        return [
            'imageIds' => __('You must select at least one image.'),
            'imageIds.*' => __('The selected images must exist.'),
            'modelPath' => __('You have to select a valid model.'),
        ];
    }

    public function mount()
    {
        $this->modelPath = array_key_first($this->availableModels);
    }

    public function render()
    {
        return view('livewire.image.manage-image-report');
    }

    /**
     *  Abre del modal para configurar el informe.
     */
    #[On('report-images')]
    public function openModalDelete($imageIds)
    {
        $this->imageIds = explode(',', $imageIds);
        $this->modal('modal-report-images')->show();
    }

    /**
     * Realiza las predicciones de las imágenes y redirecciona a la generación
     * del archivo PDF.
     */
    public function reportImages(PythonService $pythonService)
    {
        $this->validate();

        $images = Image::with('media')
            ->whereIn('id', $this->imageIds)
            ->get()
            ->sortBy(fn($image) => array_search($image->getKey(), $this->imageIds))
            ->values();

        $images->each(fn($image) => Gate::authorize('report', $image));

        $imagePaths = $images->map(function ($image) {
                return $image->getFirstMedia('*')->getPath();
        })->toArray();

        $imagePaths = implode(' ', $imagePaths);
        $model = CnnModel::where('name', $this->availableModels()[$this->modelPath])->first();
        $classLabels = $model->labels->pluck('id')->toArray();

        $args = [
            '--model_path' => $this->modelPath,
            '--image_paths' => $imagePaths,
            '--class_labels' => json_encode($classLabels),
        ];

        $output = $pythonService->runScript(
            script: 'predict_image.py',
            args: $args
        );

        $patron = '/^\d+\s*\|\s*\d{2}\.\d{2}$/'; // Estructura definida para las predicciones.
        $this->predictions = array_values(preg_grep($patron, $output));
        $this->modelId = $model->id;

        $this->modal('modal-report-images')->hide();
        $this->toast(title: __('Success'), message: __('The images where analyzed successfully.'))->success();
        $this->dispatch('images-reported');
    }
}
