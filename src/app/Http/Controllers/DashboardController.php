<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('dashboard');
    }
}
