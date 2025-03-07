<?php

namespace App\Livewire\Dashboard;

use App\Models\Label;
use Livewire\Component;

class ImagesDistribution extends Component
{
    public function render()
    {
        return view('livewire.dashboard.images-distribution');
    }

    /**
     * Contabiliza imágenes por distribución.
     */
    public function countImages()
    {
        $labels = Label::withCount('images')->get()->map(function ($label) {
            return [
                'id' => $label->id,
                'name' => $label->name,
                'color' => $label->color,
                'count_images' => $label->count_images
            ];
        })->toArray();

        $this->dispatch('show-distribution-chart',
            chartColors: array_column($labels, 'color'),
            labels: array_column($labels, 'name'),
            data: array_column($labels, 'count_images')
        );
    }
}
