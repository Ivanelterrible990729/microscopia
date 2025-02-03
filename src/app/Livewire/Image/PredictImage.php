<?php

namespace App\Livewire\Image;

use App\Enums\Media\MediaEnum;
use App\Models\CNNModel;
use App\Models\Image;
use App\Models\Label;
use App\Services\PythonService;
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
        $modelMedia = $model->getFirstMedia(MediaEnum::CNN_MODEL->value);
        $imageMedia = $this->image->getFirstMedia(MediaEnum::Images->value);

        $args = [
            '--model_path' => $modelMedia?->getPath() ?? 'path del modelo',
            '--image_path' => $imageMedia->getPath(),
            '--class_labels' => json_encode($model->labels->pluck('name')->toArray()),
        ];

        $pythonService = new PythonService();
        $output = $pythonService->runScript(
            script: 'predict_image.py',
            args: $args
        );

        $output = array_values(array_slice($output, -2, 2, true));
        $labelName = $output[0];
        $percentage = $output[1];

        $label = Label::whereName($labelName)->first();

        if ($label) {
            $this->prediction = [
                'percentage' => number_format($percentage, 2),
                'name' => $label->name,
                'color' => $label->color,
            ];
        }
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
