<?php

namespace App\Http\Controllers;

use App\Enums\Permissions\CnnModelPermission;
use App\Models\CnnModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CnnModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', CnnModel::class);

        $canCreateModel = request()->user()->can(CnnModelPermission::Create);

        return view('cnn-model.index', compact($canCreateModel));
    }

    /**
     * Display the specified resource.
     */
    public function show(CnnModel $cnnModel)
    {
        Gate::authorize('view', $cnnModel);

        return view('cnn-model.show', compact('cnnModel'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CnnModel $cnnModel)
    {
        Gate::authorize('delete', $cnnModel);
    }
}
