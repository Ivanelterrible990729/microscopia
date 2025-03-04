<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageLabelingRequest;
use App\Models\Image;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

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
    public function labeling(ImageLabelingRequest $request)
    {
        $images = Image::with(['media', 'labels'])
            ->whereIn('id', $request->imageIds())
            ->get()
            ->sortBy(fn($image) => array_search($image->getKey(), $request->imageIds()))
            ->values();

        if ($images->count() === 1) {
            Session::reflash();
            return redirect()->route('image.edit', $images->first()->id);
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
}
