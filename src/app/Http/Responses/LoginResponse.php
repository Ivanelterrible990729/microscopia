<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Session;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Una vez loggeado el usuario, se verifica la información del usuario.
     * - Si el usuario tiene su registro completo, redirige a dashboard.
     * - Si el usuario no cuenta con su registro completo, se redirige a completar-registro.
     *
     * @param Request $request
     * @return string
     */
    public function toResponse($request)
    {
        Session::flash('alert', [
            'variant' => 'success',
            'icon' => 'home',
            'message' => __('Welcome to the ITRANS Microscopy System. 🔬')
        ]);

        return redirect()->intended('dashboard');
    }
}
