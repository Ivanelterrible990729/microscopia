<?php

namespace App\Policies;

use App\Enums\Permissions\UserPermission;
use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->hasPermissionTo(UserPermission::ViewAny)
            ? Response::allow()
            : Response::deny(__('#UP-VA-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): Response
    {
        return $user->hasPermissionTo(UserPermission::View)
            ? Response::allow()
            : Response::deny(__('#UP-VI-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasPermissionTo(UserPermission::Create)
            ? Response::allow()
            : Response::deny(__('#UP-CR-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function personify(User $user, User $model): Response
    {
        if ($user->hasPermissionTo(UserPermission::Personify) && $model->id != $user->id && Session::missing('personified_by')) {

            if ($model->hasRole(RoleEnum::Desarrollador) && !$user->hasRole(RoleEnum::Desarrollador)) {
                return Response::deny(__('#UP-PE-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
            }

            return Response::allow();
        }

        return Response::deny(__('#UP-PE-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): Response
    {
        if ($user->hasPermissionTo(UserPermission::Delete) && $model->id != $user->id) {

            if ($model->hasRole(RoleEnum::Desarrollador) && !$user->hasRole(RoleEnum::Desarrollador)) {
                return Response::deny(__('#UP-PE-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
            }

            return Response::allow();
        }

        return Response::deny(__('#UP-PE-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function assignRoles(User $user, User $model): Response
    {
        if ($user->hasPermissionTo(UserPermission::AssignRoles)) {

            if ($model->hasRole(RoleEnum::Desarrollador) && !$user->hasRole(RoleEnum::Desarrollador)) {
                return Response::deny(__('#UP-PE-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
            }

            return Response::allow();
        }

        return Response::deny(__('#UP-PE-'. Auth::id() .':' . __('You do not have permissions to perform this action.')), 403);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
