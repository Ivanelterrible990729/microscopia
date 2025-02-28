<?php

namespace App\Policies;

use App\Enums\Permissions\LabelPermission;
use App\Models\Label;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class LabelPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasPermissionTo(LabelPermission::Create)
            ? Response::allow()
            : Response::deny(__('#LP-CR-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Label $label): Response
    {
        return $user->hasPermissionTo(LabelPermission::Update)
            ? Response::allow()
            : Response::deny(__('#LP-UP-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Label $label): Response
    {
        return $user->hasPermissionTo(LabelPermission::Delete)
            ? Response::allow()
            : Response::deny(__('#LP-DE-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Label $label): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Label $label): bool
    {
        return false;
    }
}
