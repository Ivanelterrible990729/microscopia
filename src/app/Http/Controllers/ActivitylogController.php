<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Models\Activity;

class ActivitylogController extends Controller
{
    public function index()
    {
        Gate::authorize('ViewAny', Activity::class);

        return view('activitylog.index');
    }
}
