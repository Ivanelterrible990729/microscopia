<?php

namespace App\Livewire\CnnModel;

use App\Contracts\Services\ActivityInterface;
use App\Enums\CnnModel\AvailableBaseModelsEnum;
use App\Enums\Media\MediaEnum;
use App\Jobs\AugmentImages;
use App\Jobs\CreateDataEnvironment;
use App\Jobs\CropImages;
use App\Jobs\RemoveDataEnvironment;
use App\Jobs\TrainModel;
use App\Livewire\Forms\TrainCnnModelForm;
use App\Models\CnnModel;
use App\Models\Label;
use App\Services\TrainModelService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
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
    public TrainCnnModelForm $form;

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

    public function mount(CnnModel $cnnModel)
    {
        $this->cnnModel = $cnnModel;

        $this->defineSteps();
        $this->availableModels = $this->getAvailableModels();
        $this->availableLabels = $this->getAvailableLabels();

        $this->form->modelPath = $cnnModel->hasMedia('*') ? $cnnModel->getFirstMedia('*')?->getPath() : array_key_first($this->availableModels);
        $this->form->selectedLabels = $cnnModel->labels->pluck('id')->toArray();
        $this->form->validationPortion = '0.2';
        $this->form->imagesLimit = $this->uploadMinImages();
    }

    /**
     * Pasos requeridos para llevar a cabo el entrenamiento.
     */
    private function defineSteps()
    {
        $this->steps = [
            [
                'method' => 'modelBackup',
                'milliseconds' => 1500,
                'next_method' => 'createEnvironment',
                'title' => __('Model backup'),
                'description' => __("This backup is to recover the last model in case the training didn't performs well."),
                'status' => null,
                'result' => null,
            ],
            [
                'method' => 'createEnvironment',
                'milliseconds' => 3000,
                'next_method' => 'imageCrop',
                'title' => __('Training environment'),
                'description' => __("Creating a new directory to allocate the training set. Getting the required images to perform the training."),
                'status' => null,
                'result' => null,
            ],
            [
                'method' => 'imageCrop',
                'milliseconds' => 3000,
                'next_method' => 'imageAugmentation',
                'title' => __('Image cropping'),
                'description' => __("This process is necessary to avoid noise during training."),
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
                'method' => 'cnnModelTraining',
                'milliseconds' => 60000,
                'next_method' => 'removeEnvironment',
                'title' => __('CNN Model training'),
                'description' => __("Performing the training process. This may take a while."),
                'status' => null,
                'result' => null,
            ],
            [
                'method' => 'removeEnvironment',
                'milliseconds' => 3000,
                'next_method' => 'finish',
                'title' => __('Removing training environment'),
                'description' => __("Once the training process it's done, we need to clear the training environment as this will not be used again."),
                'status' => null,
                'result' => null,
            ],
        ];

        if (! Cache::has('on-model-training')) {
            return;
        }

        $this->onTraining = true;

        if ($this->cnnModel->hasMedia('*')) {
            $this->steps[$this->activeStep]['status'] = 'successfull';
            $this->steps[$this->activeStep]['result'] = __('Model downloaded.');
        } else {
            unset($this->steps[$this->activeStep]);
            $this->activeStep++;
        }

        $index = 0;
        for ($index = 1; $index < count($this->steps); $index++) { // Ignoramos modelBackup porque ese método no necesita de caché.
            $method = $this->steps[$index]['method'];

            if (Cache::has($method)) {
                $this->activeStep = $index;
                $this->steps[$index]['status'] = Cache::get($method);

                if (Cache::has($method . 'Finished')) {
                    $this->steps[$index]['result'] = Cache::get($method . 'Finished');
                }
            } else {
                $status = $this->steps[$this->activeStep]['status'];

                if ($status === 'error') {
                    break;
                }

                if ($status == 'processing') {
                    $this->dispatch('check-process', method: $this->steps[$this->activeStep]['method'], milliseconds: $this->steps[$this->activeStep]['milliseconds'])->self();
                }

                if ($status == 'successfull') {
                    $this->goToNextStep(result: $this->steps[$this->activeStep]['method'], method: $this->steps[$this->activeStep]['next_method']);
                }

                break;
            }
        }

        if ($index == count($this->steps)) {
            $this->finish(result: __('Environment removed.'));
        }
    }

    /**
     * Obtiene los modelos de los cuales partir el entrenamiento.
     */
    private function getAvailableModels(): array
    {
        $availableModels = AvailableBaseModelsEnum::arrayResource();
        $modelsMedia = CnnModel::whereHas('media')
            ->with('media')
            ->get()
            ->map(function($cnnModel) {
                return [
                    $cnnModel->getFirstMedia(MediaEnum::CNN_Model->value)->getPath() => $cnnModel->name,
                ];
            })->toArray();

        $availableModels += array_reduce($modelsMedia, function (null|array $carry, array $item) {
            return is_null($carry) ? $item : $carry += $item;
        });

        return $availableModels;
    }

    /**
     * Obtiene las etiquetas disponibles para realizar el entrenamiento.
     */
    private function getAvailableLabels(): array
    {
        return Label::withCount(['images' => function ($query) {
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
    }

    /**
     * Esta función se utiliza para recalcular el numero mínimo de imágenes
     * que se utilizará por cada etiqueta en el entrenamiento.
     * Se utiliza en el front con fines informativos y actualiza $this->form->imagesLimit
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
        return view('livewire.cnn-model.train-cnn-model');
    }

    /**
     * Comienza el proceso de entrenamiento.
     */
    public function trainModel(ActivityInterface $activityService): void
    {
        Gate::authorize('train', $this->cnnModel);
        $this->validate();

        $activityService->logActivity(
            logName: __('CNN Models'),
            performedOn: $this->cnnModel,
            properties: [],
            description: __('Model training executed.'),
        );

        $this->onTraining = true;
        Cache::put('on-model-training', true);

        if ($this->cnnModel->hasMedia('*')) {
            $this->dispatch('next-step', method: 'modelBackup')->self();
            return;
        }

        unset($this->steps[$this->activeStep]);
        $this->steps[++$this->activeStep]['status'] = 'processing';
        $this->dispatch('next-step', method: 'createEnvironment')->self();
    }

    /**
     * Realiza la descarga del modelo (Si es que existía alguno).
     * - NOTA: Este método no necesita estar en cache dado que el respaldo es instantaneo.
     */
    public function modelBackup(TrainModelService $trainMoodelService)
    {
        $this->goToNextStep(result: __('Model downloaded.'), method: 'createEnvironment');

        return $trainMoodelService->downloadModel(
            modelMedia: $this->cnnModel->getFirstMedia(MediaEnum::CNN_Model->value)
        );
    }

    /**
     * Crea el ambiente de entrenamiento generando los directorios correspondientes
     * y moviendo las imagenes correspondientes
     */
    public function createEnvironment(): void
    {
        Cache::put($this->steps[$this->activeStep]['method'], $this->steps[$this->activeStep]['status']); // Processing
        $this->dispatch('check-process', method: $this->steps[$this->activeStep]['method'], milliseconds: $this->steps[$this->activeStep]['milliseconds'])->self();

        CreateDataEnvironment::dispatch(
            method: $this->steps[$this->activeStep]['method'],
            availableLabels: $this->availableLabels,
            selectedLabels: $this->form->selectedLabels,
            maxNumImages: $this->form->imagesLimit
        );
    }

    /**
     * Realiza el recorte de imagenes para evitar ruido por las métricas de la muestra tomada.
     */
    public function imageCrop(): void
    {
        Cache::put($this->steps[$this->activeStep]['method'], $this->steps[$this->activeStep]['status']); // Processing
        $this->dispatch('check-process', method: $this->steps[$this->activeStep]['method'], milliseconds: $this->steps[$this->activeStep]['milliseconds'])->self();

        CropImages::dispatch(method: $this->steps[$this->activeStep]['method']);
    }

    /**
     * Realiza data augmentation para enriquecer la generalización del modelo.
     */
    public function imageAugmentation(): void
    {
        Cache::put($this->steps[$this->activeStep]['method'], $this->steps[$this->activeStep]['status']); // Processing
        $this->dispatch('check-process', method: $this->steps[$this->activeStep]['method'], milliseconds: $this->steps[$this->activeStep]['milliseconds'])->self();

        AugmentImages::dispatch(method: $this->steps[$this->activeStep]['method']);
    }

    /**
     * Realiza el entrenamiento del modelo, y si todo salió bien, entonces actualiza modelo.
     */
    public function cnnModelTraining(): void
    {
        Cache::put($this->steps[$this->activeStep]['method'], $this->steps[$this->activeStep]['status']); // Processing
        $this->dispatch('check-process', method: $this->steps[$this->activeStep]['method'], milliseconds: $this->steps[$this->activeStep]['milliseconds'])->self();

        TrainModel::dispatch(
            method: $this->steps[$this->activeStep]['method'],
            cnnModel: $this->cnnModel,
            availableLabels: $this->availableLabels,
            selectedLabels: $this->form->selectedLabels,
            modelDirectory: $this->form->modelPath,
            validationPortion: $this->form->validationPortion
        );
    }

    public function removeEnvironment(): void
    {
        Cache::put($this->steps[$this->activeStep]['method'], $this->steps[$this->activeStep]['status']); // Processing
        $this->dispatch('check-process', method: $this->steps[$this->activeStep]['method'], milliseconds: $this->steps[$this->activeStep]['milliseconds'])->self();

        RemoveDataEnvironment::dispatch(method: $this->steps[$this->activeStep]['method']);
    }

    /**
     * Esta función se encarga de evaluar contantemente el proceso que se esté ejecutando por medio de un job.
     */
    public function checkStatusProcess(string $method)
    {
        if (Cache::has($method . 'Finished')) {

            if (Cache::get($method) == 'error') {
                $this->stopTraining(result: Cache::get($method . 'Finished'));
                return 'error';
            }

            $nextMethod = $this->steps[$this->activeStep]['next_method'];
            if ($nextMethod == 'finish') {
                $this->finish(result: Cache::get($method . 'Finished'));
            } else {
                $this->goToNextStep(result: Cache::get($method . 'Finished'), method: $nextMethod);
            }

            return 'successfull';
        }

        return $this->steps[$this->activeStep]['status'];
    }

    /**
     * Actualiza el flujo del entrenamiento según los parámetros indicados
     */
    private function goToNextStep(string $result, string $method): void
    {
        $this->steps[$this->activeStep]['status'] = 'successfull';
        $this->steps[$this->activeStep]['result'] = $result;

        $this->steps[++$this->activeStep]['status'] = 'processing';
        $this->dispatch('next-step', method: $method)->self();
    }

    /**
     * Finaliza el flujo del entrenamiento y manda mensaje
     * de confirmación.
     */
    private function finish(string $result): void
    {
        $this->steps[$this->activeStep]['status'] = 'successfull';
        $this->steps[$this->activeStep]['result'] = $result;
        $this->activeStep = count($this->steps);

        $this->dispatch('refresh-model');
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
        $this->steps[$this->activeStep]['result'] = $result . ' Training environment removed.';

        (new TrainModelService)->removeEnvironment();

        $this->toast(title: __('Error'), message: $result)->danger();
    }

    /**
     * Regresa al formulario de entrenamiento.
     * - Limpia la caché empleada para el entrenamiento.
     * - Reinicia las etiquetas de entrenamiento y los pasos para realizar el entrenamiento.
     */
    public function backToForm(): void
    {
        Cache::clear();
        $this->reset(['activeStep', 'onTraining']);
        $this->defineSteps();
    }
}
