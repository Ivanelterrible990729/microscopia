<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Image::class);

        return view('image.index');
    }

    /**
     * Show the form for creating-updating a new resource.
     */
    public function labeling(Request $request)
    {
        $imageIds = explode(',', $request->ids);

        $images = Image::with(['media', 'labels'])
            ->whereIn('id', $imageIds)
            ->get()
            ->sortBy(function($model) use ($imageIds){
                return array_search($model->getKey(), $imageIds);
            })->values();

        // TODO: validar que exista al menos una imagen recibida por medio de un FormRequest.

        foreach ($images as $image) {
            Gate::authorize('update', $image);
        }

        return view('image.labeling', compact('images'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        Gate::authorize('view', $image);

        $image->load([
            'user',
            'media',
            'labels'
        ]);

        return view('image.show', compact('image'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Image $image)
    {
        Gate::authorize('update', $image);

        $image->load([
            'user',
            'media',
            'labels',
        ]);

        return view('image.edit', compact('image'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {

    }
}
