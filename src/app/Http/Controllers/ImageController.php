<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageLabelingRequest;
use App\Http\Requests\ImageReportRequest;
use App\Models\CnnModel;
use App\Models\Image;
use App\Models\Label;
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
    public function pdfReport(ImageReportRequest $request)
    {
        $data = $request->validated();

        $images = Image::with('media')
            ->whereIn('id', $data['imageIds'])
            ->get()
            ->sortBy(fn($image) => array_search($image->getKey(), $data['imageIds']))
            ->values();

        $labels = Label::all()
            ->pluck('name', 'id')
            ->toArray();

        $cnnModel = CnnModel::find($data['modelId']);

        $report = [];
        foreach ($images as $index => $image) {

            $imageData = base64_encode(file_get_contents($image->getFirstMedia('*')->getPath('preview')));
            $base64Image = 'data:image/jpeg;base64,' . $imageData;

            list($labelId, $percentage) = explode("|", $data['predictions'][$index]);
            $labelId = trim($labelId);
            $percentage = trim($percentage);

            $report[] = [
                'image_name' => $image->name,
                'image_description' => $image->description,
                'illustration' => $base64Image,
                'prediction' => $labels[$labelId],
                'precision' => $percentage,
            ];
        }

        return Pdf::view('pdf.image-report', [
            'report' => $report,
        ])->format('letter')->name(__('Analysis report - ') . time() . '.pdf');
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
