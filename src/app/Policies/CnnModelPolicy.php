<?php

namespace App\Policies;

use App\Enums\Permissions\CnnModelPermission;
use App\Models\CnnModel;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class CnnModelPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->hasPermissionTo(CnnModelPermission::ViewAny)
            ? Response::allow()
            : Response::deny(__('#CMP-VA-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CnnModel $cnnModel): Response
    {
        return $user->hasPermissionTo(CnnModelPermission::View)
            ? Response::allow()
            : Response::deny(__('#CMP-V-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasPermissionTo(CnnModelPermission::Create)
            ? Response::allow()
            : Response::deny(__('#CMP-C-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CnnModel $cnnModel): Response
    {
        return $user->hasPermissionTo(CnnModelPermission::Update)
            ? Response::allow()
            : Response::deny(__('#CMP-U-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CnnModel $cnnModel): Response
    {
        return $user->hasPermissionTo(CnnModelPermission::Delete)
            ? Response::allow()
            : Response::deny(__('#CMP-D-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
    }

    /**
     * Determina si el usuario puede realizar el entrenamiento.
     */
    public function train(User $user, CnnModel $cnn_model): Response
    {
        return $user->hasPermissionTo(CnnModelPermission::Train)
            ? Response::allow()
            : Response::deny(__('#CMP-TR-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CnnModel $cnnModel): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CnnModel $cnnModel): bool
    {
        return false;
    }
}
