<?php

namespace App\Jobs;

use App\Services\TrainModelService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CreateDataEnvironment implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected string $method,
        protected array $availableLabels,
        protected array $selectedLabels,
        protected int $maxNumImages,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(TrainModelService $trainModelService): void
    {
        try {
            $numLabels = $trainModelService->createEnvironment(
                availableLabels: $this->availableLabels,
                selectedLabels: $this->selectedLabels,
                maxNumImages: $this->maxNumImages
            );

            Cache::put($this->method, 'successfull');
            Cache::put($this->method . 'Finished',  __('Environment created.') . ' (' . $numLabels . ' ' . __('labels') . ').');
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            Cache::put($this->method, 'error');
            Cache::put($this->method . 'Finished',  __('Environment creation failed.') . ' ' . __('See log-viewer for more details.'));
        }
    }
}
