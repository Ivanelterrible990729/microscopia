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

        return view('cnn-model.index', compact('canCreateModel'));
    }

    /**
     * Display the specified resource.
     */
    public function show(CnnModel $cnnModel)
    {
        Gate::authorize('view', $cnnModel);

        $cnnModel->load(['labels', 'media']);
        $canDownloadModel = $cnnModel->hasMedia('*');
        $canUpdateModel = request()->user()->can(CnnModelPermission::Update);
        $canDeleteModel = request()->user()->can(CnnModelPermission::Delete);

        return view('cnn-model.show', compact('cnnModel', 'canDeleteModel', 'canUpdateModel', 'canDownloadModel'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CnnModel $cnnModel)
    {
        Gate::authorize('delete', $cnnModel);

        $cnnModel->delete();

        return redirect(route('cnn-model.index'))->with([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The model has been successfully removed.')
            ]
        ]);
    }
}
