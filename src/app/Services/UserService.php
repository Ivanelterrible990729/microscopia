<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository
    ) {}

    /**
     * Proceso de eliminación de un usuario.
     */
    public function deleteUser(User $user): void
    {
        $this->userRepository->delete($user);
    }

    /**
     * Proceso de restauración de usuario.
     */
    public function restoreUser(User $user): void
    {
        $this->userRepository->restore($user);
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

        return $personifiedUser;
    }
}
