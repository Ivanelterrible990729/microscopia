<?php

namespace App\Livewire\Image;

use App\Enums\Media\MediaEnum;
use App\Models\Image;
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
            'files.*' => 'image|max:' . config('media.max_file_size', 1024 * 1024 * 10)
        ];
    }

    protected function validationAttributes()
    {
        return [
            'files' => 'imágenes',
            'files.*' => 'imagen',
        ];
    }

    public function uploadFiles()
    {
        $this->validate();

        $imageIds = [];

        foreach ($this->files as $file) {
            $image = Image::create([
                'user_id' => request()->user()->id,
                'name' => $file->getClientOriginalName(),
            ]);

            $image->addMedia($file)->toMediaCollection(MediaEnum::Images->value);

            $imageIds[] = $image->id;
        }

        return redirect()->route('images.image-labeling', ['ids' => implode(',', $imageIds)])->with([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => count($imageIds) == 1
                    ? __('Image uploaded successfully')
                    : __('Images uploaded successfully')
            ]
        ]);
    }

    public function render()
    {
        return view('livewire.image.upload-images');
    }
}
