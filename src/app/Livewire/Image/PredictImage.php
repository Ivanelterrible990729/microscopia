<?php

namespace App\Livewire\Image;

use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class PredictImage extends Component
{
    use WithPagination;

    public Collection $models;

    public function mount()
    {

    }

    public function render()
    {
        return view('livewire.image.predict-image');
    }

    public function predict()
    {

    }
}
