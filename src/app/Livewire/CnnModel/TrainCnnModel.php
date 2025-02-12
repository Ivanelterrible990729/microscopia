<?php

namespace App\Livewire\CnnModel;

use Livewire\Component;

class TrainCnnModel extends Component
{
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

    public function mount()
    {
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
                'description' => __("Creating a new directory to allocate the training set."),
                'result' => null,
            ],
            [
                'status' => null,
                'title' => __('Exctract images for training'),
                'description' => __("Getting the required images to perform the training."),
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

    public function render()
    {
        return view('livewire.cnn-model.train-cnn-model');
    }

    public function trainModel(): void
    {
        $this->onTraining = true;
        $this->steps[$this->activeStep]['status'] = 'processing';
        $this->dispatch('next-step', method: 'modelBackup')->self();
    }

    public function modelBackup(): void
    {
        if ($this->trainingCancelled) {
            $this->stopTraining(__('Process stopped by the user'));
            return;
        }

        sleep(2);

        $this->goToNextStep(result: __('Model downloaded.'), method: 'trainingEnvironment');
    }

    public function trainingEnvironment(): void
    {
        if ($this->trainingCancelled) {
            $this->stopTraining(__('Process stopped by the user'));
            return;
        }

        sleep(2);

        $this->goToNextStep(result: '', method: 'extractImagesForTraining');
    }

    public function extractImagesForTraining(): void
    {
        if ($this->trainingCancelled) {
            $this->stopTraining(__('Process stopped by the user'));
            return;
        }

        sleep(2);

        $this->goToNextStep(result: '', method: 'imageCropping');
    }

    public function imageCropping(): void
    {
        if ($this->trainingCancelled) {
            $this->stopTraining(__('Process stopped by the user'));
            return;
        }

        sleep(2);

        $this->goToNextStep(result: '', method: 'imageAugmentation');
    }

    public function imageAugmentation(): void
    {
        if ($this->trainingCancelled) {
            $this->stopTraining(__('Process stopped by the user'));
            return;
        }

        sleep(2);

        $this->goToNextStep(result: '', method: 'cnnModelTraining');
    }

    public function cnnModelTraining(): void
    {
        if ($this->trainingCancelled) {
            $this->stopTraining(__('Process stopped by the user'));
            return;
        }

        sleep(2);

        $this->goToNextStep(result: '', method: 'removingTrainingEnvironment');
    }

    public function removingTrainingEnvironment(): void
    {
        if ($this->trainingCancelled) {
            $this->stopTraining(__('Process stopped by the user'));
            return;
        }

        sleep(2);

        $this->finish('');
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
