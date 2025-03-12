<?php

namespace App\Jobs;

use App\Models\CnnModel;
use App\Services\CnnModelService;
use App\Services\TrainModelService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TrainModel implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected string $method,
        protected CnnModel $cnnModel,
        protected array $availableLabels,
        protected array $selectedLabels,
        protected string $modelDirectory,
        protected string $validationPortion,
    ) {}


    /**
     * Execute the job.
     */
    public function handle(TrainModelService $trainModelService, CnnModelService $cnnModelService): void
    {
        try {
            $metrics = $trainModelService->trainModel(
                availableLabels: $this->availableLabels,
                selectedLabels: $this->selectedLabels,
                modelDirectory: $this->modelDirectory,
                validationPortion: $this->validationPortion
            );

            if (empty($metrics)) {
                Cache::put($this->method, 'error');
                Cache::put($this->method . 'Finished', __('Training process failed.'));
                return;
            }

            $metrics = $cnnModelService->updateModelTrained(
                cnnModel: $this->cnnModel,
                metrics: $metrics,
                labelIds: $this->selectedLabels,
                modelPath: $this->modelDirectory
            );

            Cache::put($this->method, 'successfull');
            Cache::put($this->method . 'Finished', __('Model trained') . ': ' . json_encode($metrics));
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            Cache::put($this->method, 'error');
            Cache::put($this->method . 'Finished',  __('Training process failed.') . ' ' . __('See log-viewer for more details.'));
        }
    }
}
