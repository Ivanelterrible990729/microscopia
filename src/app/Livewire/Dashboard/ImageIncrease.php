<?php

namespace App\Livewire\Dashboard;

use App\Models\Image;
use Illuminate\Support\Carbon;
use Livewire\Component;

class ImageIncrease extends Component
{
    /**
     * Fechas para realizar la consulta en el gráfico
     */
    public string $dates;

    /**
     *  resumen de imágenes
     */
    public array $images = [];

    public function mount()
    {
        $endDate = now()->subMonth()->translatedFormat('j M, Y');
        $startDate = now()->subMonth(3)->translatedFormat('j M, Y');

        $this->dates = $startDate . ' - ' . $endDate;
        $this->images = [
            'this month' =>  Image::whereMonth('created_at', now()->month)->count(),
            'last month' =>  Image::whereMonth('created_at', now()->subMonth()->month)->count()
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.image-increase');
    }

    public function countImages(string $dates)
    {
        $dates = explode(' - ', $dates);

        if (count($dates) != 2) {
            $this->toast(title: __('Error'), message: __('Format error'))->danger();
            return;
        }

        $startDate = Carbon::createFromLocaleFormat('j M, Y', 'es', str_replace('.', '', $dates[0]));
        $endDate = Carbon::createFromLocaleFormat('j M, Y', 'es', str_replace('.', '', $dates[1]));

        $monthsInRange = [];
        $currentMonth = $startDate->copy();

        while ($currentMonth->lte($endDate)) {
            $monthsInRange[] = $currentMonth->format('M, Y');
            $currentMonth->addMonth();
        }

        $imagesCountByMonth = array_fill_keys($monthsInRange, 0);

        $images = Image::whereBetween('created_at', [$startDate, $endDate])->get();

        foreach ($images as $image) {
            $monthYear = $image->created_at->format('M, Y');

            if (isset($imagesCountByMonth[$monthYear])) {
                $imagesCountByMonth[$monthYear]++;
            }
        }

        $this->dispatch('show-increase-chart',
            labels: array_keys($imagesCountByMonth),
            data: array_values($imagesCountByMonth)
        )->self();
    }
}
