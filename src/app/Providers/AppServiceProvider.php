<?php

namespace App\Providers;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Policies\ActivityPolicy;
use App\Policies\RolePolicy;
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
        //
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
    }
}
