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
            'files.*' => 'image|max:10048', // Validar cada archivo
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
