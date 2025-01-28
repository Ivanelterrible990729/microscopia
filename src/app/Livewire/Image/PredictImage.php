<?php

namespace App\Livewire\Image;

use App\Models\CNNModel;
use App\Models\Image;
use App\Models\Label;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class PredictImage extends Component
{
    use WithPagination;
    use WithoutUrlPagination;

    /**
     * Imagen a la cual realizar las predicciones
     */
    public Image $image;

    /**
     * Almacena la predicción realizada por el modelo a la imagen en cuestión.
     */
    public null|array $prediction = null;

    public function render()
    {
        $models = CNNModel::query()->paginate(1);

        return view('livewire.image.predict-image', compact('models'));
    }

    public function predict(CNNModel $model)
    {
        // Simula la predicción
        $label = Label::inRandomOrder()->first();
        sleep(1);

        $this->prediction = [
            'percentage' => rand(80, 100),
            'name' => $label->name,
            'color' => $label->color,
        ];
    }

    /**
     * Utiliza el hook de cambio de página para mandar un evento
     * que se escucha en el blade y así llamar a la función predict después del render.
     */
    public function updatedPage($page)
    {
        $this->dispatch('updated-page');
    }
}
