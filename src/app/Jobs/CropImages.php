<?php

namespace App\Jobs;

use App\Services\TrainModelService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CropImages implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected string $method
    ) {}

    /**
     * Execute the job.
     */
    public function handle(TrainModelService $trainModelService): void
    {
        try {
            $numImages = $trainModelService->cropImages();

            if ($numImages == 0) {
                Cache::put($this->method, 'error');
                Cache::put($this->method . 'Finished',  __('Cropping process failed.'));
                return;
            }

            Cache::put($this->method, 'successfull');
            Cache::put($this->method . 'Finished', $numImages . ' ' . __('images were cropped successfully.'));
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            Cache::put($this->method, 'error');
            Cache::put($this->method . 'Finished',  __('Cropping process failed.') . ' ' . __('See log-viewer for more details.'));
        }
    }
}
