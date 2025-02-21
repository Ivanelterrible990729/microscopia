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
     * Determine whether the user can view the model.
     */
    public function view(User $user, Activity $activity): Response
    {
        return $user->hasPermissionTo(ActivitylogPermission::View)
            ? Response::allow()
            : Response::deny(__('#UP-VI-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Activity $activity): Response
    {
        return $user->hasPermissionTo(ActivitylogPermission::Delete)
            ? Response::allow()
            : Response::deny(__('#UP-DE-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
    }
}
