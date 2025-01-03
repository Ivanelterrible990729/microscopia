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
        return $user->hasPermissionTo(RolePermission::ViewAny)
            ? Response::allow()
            : Response::deny(__('#RP-VA-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Role $role): Response
    {
        return $user->hasPermissionTo(RolePermission::View)
            ? Response::allow()
            : Response::deny(__('#RP-VI-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasPermissionTo(RolePermission::Create)
            ? Response::allow()
            : Response::deny(__('#RP-CR-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Role $role): Response
    {
        return $user->hasPermissionTo(RolePermission::Update)
            ? Response::allow()
            : Response::deny(__('#RP-UP-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Role $role): Response
    {
        return $user->hasPermissionTo(RolePermission::Delete)
            ? Response::allow()
            : Response::deny(__('#RP-DE-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
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
