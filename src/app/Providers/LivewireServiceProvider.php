<?php

namespace App\Providers;

use App\Utils\Livewire\Modal;
use App\Utils\Livewire\Toast;
use Illuminate\Support\ServiceProvider;

class LivewireServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Modal::registerMethod();
        Toast::registerMethod();
    }
}
