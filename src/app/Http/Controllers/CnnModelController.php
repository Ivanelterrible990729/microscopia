<?php

namespace App\Http\Controllers;

use App\Models\CnnModel;
use App\Services\CnnModelService;
use Illuminate\Support\Facades\Gate;

class CnnModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', CnnModel::class);

        return view('cnn-model.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(CnnModel $cnnModel)
    {
        Gate::authorize('view', $cnnModel);

        $cnnModel->load(['labels', 'media']);

        return view('cnn-model.show', compact('cnnModel'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CnnModelService $cnnModelService, CnnModel $cnnModel)
    {
        Gate::authorize('delete', $cnnModel);

        $cnnModelService->deleteCnnModel($cnnModel);

        return redirect(route('cnn-model.index'))->with([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The model has been successfully removed.')
            ]
        ]);
    }
}
