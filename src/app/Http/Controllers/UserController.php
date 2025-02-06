<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
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
            Session::flash('alert', [
                'variant' => 'warning',
                'icon' => 'alert-triangle',
                'message' => __('This user is not active. Please restore the user to make effective any action of this user')
            ]);
        }

        return view('user.show', compact('user'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);

        $user->delete();

        return redirect(route('user.index'))->with([
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
    public function restore(User $user)
    {
        Gate::authorize('restore', $user);

        $user->restore();

        return redirect(route('user.index'))->with([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The user has been successfully restored.')
            ]
        ]);
    }

    public function downloadProfilePhoto(User $user): StreamedResponse
    {
        // Verifica si el usuario tiene una foto de perfil
        if (!$user->profile_photo_path || !Storage::disk(config('jetstream.profile_photo_disk'))->exists($user->profile_photo_path)) {
            abort(404, 'La fotografía de perfil no existe.');
        }

        return Storage::download($user->profile_photo_path, 'profile_photo_' . $user->id . '.jpg');
    }

    public function startPersonification(User $user, Request $request)
    {
        Gate::authorize('personify', $user);

        $originalId = Auth::guard('web')->id();
        Auth::guard('web')->loginUsingId($user->id);
        $request->setUserResolver(fn () => $user);
        Session::put('personified_by', $originalId);

        return redirect()->route('dashboard')->with([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('Successful impersonation.')
            ]
        ]);
    }

    public function stopPersonification(Request $request)
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

        $personifier = Auth::guard('web')->user();
        $userId = $request->session()->get('personified_by');

        if ($userId) {
            $user = User::findorFail($userId);
            Auth::guard('web')->loginUsingId($user->id);
            $request->setUserResolver(fn () => $user);

            Session::forget('personified_by');
        }

        return redirect()->route('user.show', $personifier)->with([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The impersonation was stopped.')
            ]
        ]);
    }
}
