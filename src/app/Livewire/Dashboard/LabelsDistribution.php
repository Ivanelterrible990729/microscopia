<?php

namespace App\Livewire\Dashboard;

use App\Models\Image;
use App\Models\Label;
use Livewire\Component;

class LabelsDistribution extends Component
{
    /**
     * Etiquetas a mostrar en el front.
     */
    public array $labels = [];

    /**
     * Total de imágenes
     */
    public int $totalImages;

    public function render()
    {
        return view('livewire.dashboard.labels-distribution');
    }

    /**
     * Contabiliza imágenes por distribución.
     */
    public function countImages()
    {
        $this->labels = Label::withCount('images')->get()->map(function ($label) {
            return [
                'id' => $label->id,
                'name' => $label->name,
                'color' => $label->color,
                'images_count' => $label->images_count
            ];
        })->toArray();

        $this->totalImages = array_sum(array_column($this->labels, 'images_count'));

        $this->dispatch('show-distribution-chart',
            chartColors: array_column($this->labels, 'color'),
            labels: array_column($this->labels, 'name'),
            data: array_column($this->labels, 'images_count')
        );
    }
}
