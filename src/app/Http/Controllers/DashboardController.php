<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function welcome()
    {
        return view('welcome');
    }

    public function inactivePage()
    {
        return view('errors.inactive');
    }

    public function dashboard()
    {
        Session::now('alert', [
            'variant' => 'success',
            'icon' => 'home',
            'message' => __('Welcome to the ITRANS Microscopy System. 🔬')
        ]);

        return view('dashboard');
    }
}
