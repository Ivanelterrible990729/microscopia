<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageLabelingRequest;
use App\Http\Requests\ImageReportRequest;
use App\Models\CnnModel;
use App\Models\Image;
use App\Services\ImageService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Spatie\LaravelPdf\Facades\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

        if (isset($image->deleted_at)) {
            Session::now('alert', [
                'variant' => 'warning',
                'icon' => 'alert-triangle',
                'message' => __('This image is trashed. Please restore the image to make effective any action of this image.')
            ]);
        }

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
     * Show the PDF report for an analysis of one or more Images
     */
    public function pdfReport(ImageReportRequest $request, ImageService $imageService)
    {
        $cnnModel = CnnModel::find($request->getModelId());
        $images = Image::with('media')
            ->whereIn('id', $request->getImageIds())
            ->get()
            ->sortBy(fn($image) => array_search($image->getKey(), $request->getImageIds()))
            ->values();

        $report = $imageService->generateReport($cnnModel, $images, $request->getPredictions());

        return Pdf::view('pdf.image-report', [
            'report' => $report,
            'cnnModel' => $cnnModel,
        ])->format('letter')->name(__('ANALYSIS REPORT') . '-' . time() . '.pdf');
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
     * Descarga la imagen.
     */
    public function downloadImage(ImageService $imageService, Image $image): StreamedResponse
    {
        return $imageService->downloadImage($image);
    }
}
