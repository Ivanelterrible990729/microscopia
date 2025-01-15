<?php

namespace App\Livewire\Image;

use Livewire\Component;
use Livewire\WithFileUploads;

class UploadImages extends Component
{
    use WithFileUploads;

    public $files = [];

    public function uploadFiles()
    {
        $this->validate([
            'files' => 'required|array|max:10',
            'files.*' => 'image|max:' . config('media.max_file_size', 1024 * 1024 * 10), // Validar cada archivo max 10MB
        ], attributes: [
            'files' => 'imágenes',
        ]);

        dd($this->files);

        foreach ($this->files as $file) {
            auth()->user()->addMedia($file)->toMediaCollection('images');
        }

        session()->flash('message', '¡Imágenes subidas exitosamente!');
        $this->reset('files'); // Resetear la lista de archivos
    }

    public function render()
    {
        return view('livewire.image.upload-images');
    }
}
