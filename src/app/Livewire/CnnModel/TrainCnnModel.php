<?php

namespace App\Livewire\CnnModel;

use App\Enums\CnnModel\AvailableModelsEnum;
use App\Enums\Media\MediaEnum;
use App\Models\CnnModel;
use App\Models\Label;
use App\Services\TrainModelService;
use Livewire\Component;

class TrainCnnModel extends Component
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
    public array $availableModels = [];

    /**
     * Catálogo de modelos disponibles
     */
    public array $availableLabels = [];

    /**
     * Pasos a realizar durante el entrenamiento de la CNN.
     */
    public array $steps = [];

    /**
     * Referencia al paso en el que se encuentra el componente.
     */
    public int $activeStep = 0;

    /**
     * Bandera que indica si el componente se encuentra en proceso de entrenamiento.
     */
    public bool $onTraining = false;

    /**
     * Bandera que indica si se canceló el entrenamiento
     */
    public bool $trainingCancelled = false;

    public function mount(CnnModel $cnnModel)
    {
        $this->cnnModel = $cnnModel;

        $this->availableModels = AvailableModelsEnum::arrayResource();
        $modelsMedia = CnnModel::whereHas('media')
            ->with('media')
            ->get()
            ->map(function($cnnModel) {
                return [
                    $cnnModel->getFirstMedia(MediaEnum::CNN_Model->value)->getPath() => $cnnModel->name,
                ];
            })->toArray();

        $this->availableModels += array_reduce($modelsMedia, function (null|array $carry, array $item) {
            return is_null($carry) ? $item : $carry += $item;
        });

        $this->availableLabels = Label::withCount(['images' => function ($query) {
                $query->whereNull('deleted_at');
            }])
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

        $this->form = [
            'selected_model' => $cnnModel->hasMedia('*') ? $cnnModel->getFirstMedia('*')?->getPath() : null,
            'selected_labels' => $cnnModel->labels->pluck('id')->toArray(),
            'validation_portion' => '0.2',
            'images_limit' => 0,
        ];

        $this->steps = [
            [
                'status' => null,
                'title' => __('Model backup'),
                'description' => __("This backup is to recover the last model in case the training didn't performs well."),
                'result' => null,
            ],
            [
                'status' => null,
                'title' => __('Training environment'),
                'description' => __("Creating a new directory to allocate the training set. Getting the required images to perform the training."),
                'result' => null,
            ],
            [
                'status' => null,
                'title' => __('Image cropping'),
                'description' => __("This process is necessary to avoid noise during training"),
                'result' => null,
            ],
            [
                'status' => null,
                'title' => __('Image augmentation'),
                'description' => __("Generating new images to enrich the dataset"),
                'result' => null,
            ],
            [
                'status' => null,
                'title' => __('CNN Model training'),
                'description' => __("Performing the training process. This may take a while."),
                'result' => null,
            ],
            [
                'status' => null,
                'title' => __('Removing training environment'),
                'description' => __("Once the training process it's done, we need to clear the training environment as this will not be used again."),
                'result' => null,
            ],
        ];
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

    public function render()
    {
        return view('livewire.cnn-model.train-cnn-model');
    }

    /**
     * Comienza el proceso de entrenamiento.
     */
    public function trainModel(): void
    {
        $this->onTraining = true;
        $this->steps[$this->activeStep]['status'] = 'processing';

        if ($this->cnnModel->hasMedia('*')) {
            $this->dispatch('next-step', method: 'modelBackup')->self();
        } else {
            unset($this->steps[$this->activeStep]);
            $this->steps[++$this->activeStep]['status'] = 'processing';
            $this->dispatch('next-step', method: 'trainingEnvironment')->self();
        }
    }

    /**
     * Realiza la descarga del modelo (Si es que existía alguno)
     */
    public function modelBackup()
    {
        if ($this->trainingCancelled) {
            $this->stopTraining(__('Process stopped by the user'));
            return;
        }

        $this->goToNextStep(result: __('Model downloaded.'), method: 'trainingEnvironment');

        return TrainModelService::downloadModel($this->cnnModel->getFirstMedia(MediaEnum::CNN_Model->value));
    }

    /**
     * Crea el ambiente de entrenamiento generando los directorios correspondentes
     * y moviendo las imagenes correspondientes
     */
    public function trainingEnvironment(): void
    {
        if ($this->trainingCancelled) {
            $this->stopTraining(__('Process stopped by the user'));
            return;
        }

        TrainModelService::createEnvironment($this->availableLabels, $this->form['selected_labels']);

        $this->goToNextStep(result: '', method: 'imageCropping');
    }

    public function imageCropping(): void
    {
        if ($this->trainingCancelled) {
            $this->stopTraining(__('Process stopped by the user'));
            return;
        }

        // Ubicación de imagenes: ModelTrainingServce::OriginalDirectory.

        $this->goToNextStep(result: '', method: 'imageAugmentation');
    }

    public function imageAugmentation(): void
    {
        if ($this->trainingCancelled) {
            $this->stopTraining(__('Process stopped by the user'));
            return;
        }

        // Ubicación de imagenes: ModelTrainingServce::CroppedDirectory.

        $this->goToNextStep(result: '', method: 'cnnModelTraining');
    }

    public function cnnModelTraining(): void
    {
        if ($this->trainingCancelled) {
            $this->stopTraining(__('Process stopped by the user'));
            return;
        }

        // Ubicación de imagenes: ModelTrainingServce::AugmentedDirectory.

        $this->goToNextStep(result: '', method: 'removingTrainingEnvironment');
    }

    public function removingTrainingEnvironment(): void
    {
        if ($this->trainingCancelled) {
            $this->stopTraining(__('Process stopped by the user'));
            return;
        }

        TrainModelService::removeEnvironment();

        $this->finish('Images moved.');
    }

    /**
     * Regresa al formulario de entrenamiento
     */
    public function backToForm(): void
    {
        $this->reset(['activeStep', 'onTraining', 'trainingCancelled']);
    }

    /**
     * Actualiza el flujo del entrenamiento según los parámetros indicados
     */
    private function goToNextStep(string $result, string $method): void
    {
        if ($this->trainingCancelled) {
            $this->stopTraining(__('Process stopped by the user'));
            return;
        }

        $this->steps[$this->activeStep]['status'] = 'successfull';
        $this->steps[$this->activeStep]['result'] = $result;

        $this->steps[++$this->activeStep]['status'] = 'processing';
        $this->dispatch('next-step', method: $method);
    }

    /**
     * Finaliza el flujo del entrenamiento y manda mensaje
     * de confirmación.
     */
    private function finish($result): void
    {
        if ($this->trainingCancelled) {
            $this->stopTraining(__('Process stopped by the user'));
            return;
        }

        // TODO: Save model and metrics

        $this->steps[$this->activeStep]['status'] = 'successfull';
        $this->steps[$this->activeStep]['result'] = $result;
        $this->activeStep = count($this->steps);

        $this->toast(title: __('Success'), message: __('Model training successfully completed. The trained Model is now in use.'))->success();
    }

    /**
     * Corta el flujo del entrenamiento, ya sea por:
     * - Un error en algún proceso.
     * - Cancelación voluntaria del usuario.
     */
    private function stopTraining(string $result): void
    {
        $this->steps[$this->activeStep]['status'] = 'error';
        $this->steps[$this->activeStep]['result'] = $result;

        $this->toast(title: __('Error'), message: $result)->danger();
    }
}
