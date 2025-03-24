<?php

namespace App\Providers;

use App\Contracts\Services\ActivityInterface;
use App\Enums\RoleEnum;
use App\Models\User;
use App\Policies\ActivityPolicy;
use App\Policies\DocumentationPolicy;
use App\Policies\RolePolicy;
use App\Services\ActivitylogService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Enlaza interfaz a ActivitylogService para el almacenamiento de acciones en el sistema.
        $this->app->bind(ActivityInterface::class, ActivitylogService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Policies de modelos que no están en App\Models.
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(Activity::class, ActivityPolicy::class);

        // Gate para permitir ver el log-viewer.
        Gate::define('viewLogViewer', function (?User $user) {
            if (config('log-viewer.enabled') === false) {
                return false;
            }

            return $user && $user->hasRole(RoleEnum::Desarrollador);
        });

        Gate::define('viewLarecipe', [DocumentationPolicy::class, 'show']);
    }
}
