<?php

namespace App\Http\Controllers;

use App\Enums\Permissions\ActivitylogPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Models\Activity;

class ActivitylogController extends Controller
{
    public function index()
    {
        Gate::authorize('ViewAny', Activity::class);

        return view('activity-log.index');
    }
}
