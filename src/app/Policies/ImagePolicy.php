<?php

namespace App\Policies;

use App\Enums\Permissions\ImagePermission;
use App\Models\Image;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ImagePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->hasPermissionTo(ImagePermission::ViewAny)
            ? Response::allow()
            : Response::deny(__('#IP-VA-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Image $image): Response
    {
        return $user->hasPermissionTo(ImagePermission::View)
            ? Response::allow()
            : Response::deny(__('#IP-VI-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasPermissionTo(ImagePermission::Upload)
            ? Response::allow()
            : Response::deny(__('#IP-CR-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Image $image): Response
    {
        return $user->hasPermissionTo(ImagePermission::Update)
            ? Response::allow()
            : Response::deny(__('#IP-UP-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Image $image): Response
    {
        return $user->hasPermissionTo(ImagePermission::Delete)
            ? Response::allow()
            : Response::deny(__('#IP-DE-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Image $image): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Image $image): bool
    {
        return false;
    }
}
