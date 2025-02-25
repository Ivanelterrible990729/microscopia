<?php

namespace App\Services;

use App\Contracts\Services\ActivityInterface;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository,
        protected ActivityInterface $activityService
    ) {}

    /**
     * Proceso de asignación de roles
     */
    public function syncRoles(User $user, array $roles): void
    {
        $this->activityService->setOldProperties($user->roles()->pluck('name', 'id')->toArray());

        $this->userRepository->syncRoles($user, $roles);

        $this->activityService->logActivity(
            logName: __('Users'),
            performedOn: $user,
            properties: $user->roles()->pluck('name', 'id')->toArray(),
            description: __('Roles assigned.')
        );
    }

    /**
     * Proceso de eliminación de un usuario.
     */
    public function deleteUser(User $user): void
    {
        $this->userRepository->delete($user);

        $this->activityService->logActivity(
            logName: __('Users'),
            performedOn: $user,
            properties: [
                'id' => $user->id,
                'prefijo' => $user->prefijo,
                'name' => $user->name,
                'cargo' => $user->cargo,
                'email' => $user->email,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'deleted_at' => $user->deleted_at,
            ],
            description: __('User deleted.')
        );
    }

    /**
     * Proceso de restauración de usuario.
     */
    public function restoreUser(User $user): void
    {
        $this->userRepository->restore($user);

        $this->activityService->logActivity(
            logName: __('Users'),
            performedOn: $user,
            properties: [
                'id' => $user->id,
                'prefijo' => $user->prefijo,
                'name' => $user->name,
                'cargo' => $user->cargo,
                'email' => $user->email,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'deleted_at' => $user->deleted_at,
            ],
            description: __('User restored.')
        );
    }

    /**
     * Descargar fotografía del usuario
     */
    public function downloadProfilePhoto($user): StreamedResponse
    {
        // Verifica si el usuario tiene una foto de perfil
        if (!$user->profile_photo_path || !Storage::disk(config('jetstream.profile_photo_disk'))->exists($user->profile_photo_path)) {
            abort(404, 'La fotografía de perfil no existe.');
        }

        return Storage::download($user->profile_photo_path, 'profile_photo_' . $user->id . '.jpg');
    }

    /**
     * Inicia la personificación del usuario indicado
     */
    public function startPersonification(User $user): void
    {
        $originalId = Auth::guard('web')->id();
        Auth::guard('web')->loginUsingId($user->id);
        request()->setUserResolver(fn () => $user);

        Session::put('personified_by', $originalId);

        $this->activityService->logActivity(
            logName: __('Users'),
            performedOn: $user,
            properties: [
                'user_id' => $user->id,
                'name' => $user->name,
            ],
            description: __('Started personification.')
        );
    }

    /**
     * Detiene la personificación activa.
     */
    public function stopPersonification(): User
    {
        $personifiedUser = Auth::guard('web')->user();
        $userId = request()->session()->get('personified_by');

        if ($userId) {
            $user = User::findorFail($userId);
            Auth::guard('web')->loginUsingId($user->id);
            request()->setUserResolver(fn () => $user);

            Session::forget('personified_by');
        }

        $this->activityService->logActivity(
            logName: __('Users'),
            performedOn: $personifiedUser,
            properties: [
                'user_id' => $personifiedUser->id,
                'name' => $personifiedUser->name,
            ],
            description: __('Stopped personification.'),
            causer: $user
        );

        return $personifiedUser;
    }
}
