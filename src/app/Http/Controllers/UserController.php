<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', User::class);

        return view('user.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        Gate::authorize('view', $user);

        if (isset($user->deleted_at)) {
            Session::now('alert', [
                'variant' => 'warning',
                'icon' => 'alert-triangle',
                'message' => __('This user is not active. Please restore the user to make effective any action of this user.')
            ]);
        }

        return view('user.show', compact('user'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserService $userService, User $user)
    {
        Gate::authorize('delete', $user);

        $userService->deleteUser($user);

        return redirect(route('user.show', $user))->with([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The user has been successfully removed.')
            ]
        ]);
    }

    /**
     * Restore the specified resource.
     */
    public function restore(UserService $userService, User $user)
    {
        Gate::authorize('restore', $user);

        $userService->restoreUser($user);

        return redirect(route('user.show', $user))->with([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The user has been successfully restored.')
            ]
        ]);
    }

    public function downloadProfilePhoto(UserService $userService, User $user): StreamedResponse
    {
        return $userService->downloadProfilePhoto($user);
    }

    public function startPersonification(UserService $userService, User $user)
    {
        Gate::authorize('personify', $user);

        $userService->startPersonification($user);

        return redirect()->route('dashboard')->with([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('Successful impersonation.')
            ]
        ]);
    }

    public function stopPersonification(UserService $userService)
    {
        //Se verifica que la suplantación de usuario está activa
        if (!Session::has('personified_by')) {
            return redirect()->route('dashboard')->with([
                'alert' => [
                    'variant' => 'soft-danger',
                    'icon' => 'octagon-alert',
                    'message' => __('Error when stopping impersonation.')
                ]
            ]);
        }

        $personifiedUser = $userService->stopPersonification();

        return redirect()->route('user.show', $personifiedUser)->with([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The impersonation was stopped.')
            ]
        ]);
    }
}
