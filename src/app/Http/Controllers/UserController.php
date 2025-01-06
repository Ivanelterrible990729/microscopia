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

        return view('user.show', compact('user'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function downloadProfilePhoto(User $user): StreamedResponse
    {
        // Verifica si el usuario tiene una foto de perfil
        if (!$user->profile_photo_path || !Storage::disk(config('jetstream.profile_photo_disk'))->exists($user->profile_photo_path)) {
            abort(404, 'La fotografía de perfil no existe.');
        }

        // Descargar el archivo
        return Storage::download($user->profile_photo_path, 'profile_photo_' . $user->id . '.jpg');
    }

    public function startPersonification(User $user, Request $request)
    {
        Gate::authorize('personify', $user);

        //Se guarda el id del usuario original
        $originalId = Auth::guard('web')->id();

        //Se ingresa como el usuario a suplantar
        Auth::guard('web')->loginUsingId($user->id);

        //Se restablece el usuario para el middleware AuthenticateSession
        $request->setUserResolver(fn () => $user);

        //Se registra el ID del usuario original para poder eliminar la identidad más tarde
        Session::put('personified_by', $originalId);

        //Se redirige a la página de inicio
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

        //Se obtiene el usuario persnoficiador
        $personifier = Auth::guard('web')->user();

        //Se obtiene el ID del usuario original
        $userId = $request->session()->get('personified_by');

        if ($userId) {
            //Se busca al usuario original
            $user = User::findorFail($userId);

            //Se cambia a la cuenta del usuario original
            Auth::guard('web')->loginUsingId($user->id);

            //Ya que sucumbí ante la desesperación, se establece manualmente el hash de la contraseña del usuario original en la sesión, porque setUserResolver por alguna razón no lo hace
            // $request->session()->put('password_hash_sanctum', $user->password);
            $request->setUserResolver(fn () => $user);

            //Se elimina la información de la suplantación de la sesión
            Session::forget('personified_by');
        }

        //Se redirige a la página de usuarios
        return redirect()->route('user.show', $personifier)->with([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The impersonation was stopped.')
            ]
        ]);
    }
}
