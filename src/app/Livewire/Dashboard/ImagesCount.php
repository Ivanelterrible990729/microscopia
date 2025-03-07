<?php

namespace App\Livewire\Dashboard;

use App\Models\Image;
use Livewire\Component;

class ImagesCount extends Component
{
    public bool $countPerformed = false;

    public array $images = [
        'total' => 0,
        'deleted' => 0,
        'labeled' => 0,
        'unlabeled' => 0
    ];

    public function render()
    {
        return view('livewire.dashboard.images-count');
    }

    /**
     * Realiza el conteo de imágenes para el dashboard.
     */
    public function countImages()
    {
        $this->images['total'] = Image::query()->count();
        $this->images['deleted'] = Image::onlyTrashed()->count();
        $this->images['labeled'] = Image::whereHas('labels')->count();
        $this->images['unlabeled'] = $this->images['total'] - $this->images['labeled'];

        $this->countPerformed = true;
    }
}
