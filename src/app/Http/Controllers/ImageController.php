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
        $images = Image::with(['media', 'labels'])
            ->whereIn('id', explode(',', $request->ids))
            ->get();

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
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        //
    }
}
