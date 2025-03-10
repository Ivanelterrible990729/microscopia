<?php

namespace App\Livewire\Image;

use App\Models\Image;
use App\Services\ImageService;
use App\Services\MediaImageService;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadImages extends Component
{
    use WithFileUploads;

    public $files = [];

    protected function rules()
    {
        return [
            'files' => 'required|array|max:10',
            'files.*' => 'image|max:' . config('max-file-size.images')
        ];
    }

    protected function validationAttributes()
    {
        return [
            'files' => 'imágenes',
            'files.*' => 'imagen',
        ];
    }

    public function uploadFiles(ImageService $imageService)
    {
        Gate::authorize('create', Image::class);
        $this->validate();

        $imageIds = $imageService->storeImages($this->files);

        return redirect()->route('image.labeling', ['ids' => implode(',', $imageIds)])->with([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => count($imageIds) == 1
                    ? __('Image uploaded successfully.') . ' ' . __('Please bring more info about this image.')
                    : __('Images uploaded successfully.') . ' ' . __('Please follow the wizard instructions.')
            ]
        ]);
    }

    public function render()
    {
        return view('livewire.image.upload-images');
    }
}
