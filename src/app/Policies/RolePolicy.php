<?php

namespace App\Policies;

use App\Enums\Permissions\RolePermission;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->hasPermissionTo(RolePermission::View)
            ? Response::allow()
            : Response::deny(__('#RP-VA-'. Auth::id() .': Usted no cuenta con permisos para realizar esta acción'), 403);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Role $spatiePermissionModelsRole): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Role $spatiePermissionModelsRole): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Role $spatiePermissionModelsRole): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Role $spatiePermissionModelsRole): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Role $spatiePermissionModelsRole): bool
    {
        return false;
    }
}
