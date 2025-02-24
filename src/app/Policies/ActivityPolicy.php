<?php

namespace App\Policies;

use App\Enums\Permissions\ActivitylogPermission;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class ActivityPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->hasPermissionTo(ActivitylogPermission::ViewAny)
            ? Response::allow()
            : Response::deny(__('#AP-VA-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function clear(User $user, Activity $activity): Response
    {
        return $user->hasPermissionTo(ActivitylogPermission::Clear)
            ? Response::allow()
            : Response::deny(__('#AP-CL-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
    }
}
