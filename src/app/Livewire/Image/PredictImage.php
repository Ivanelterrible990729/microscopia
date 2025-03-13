<?php

namespace App\Livewire\Image;

use App\Enums\Media\MediaEnum;
use App\Models\CnnModel;
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
    public null|array $predictions = [];

    public function render()
    {
        $models = CnnModel::whereHas('media')->paginate(1);

        return view('livewire.image.predict-image', compact('models'));
    }

    public function predict(CnnModel $model)
    {
        $modelMedia = $model->getFirstMedia(MediaEnum::CNN_Model->value);
        $imageMedia = $this->image->getFirstMedia('*');

        $args = [
            '--model_path' => $modelMedia->getPath(),
            '--image_paths' => $imageMedia->getPath(),
            '--class_labels' => json_encode($model->labels->pluck('id')->toArray()),
        ];

        $pythonService = new PythonService();
        $output = $pythonService->runScript(
            script: 'predict_image.py',
            args: $args
        );

        $patron = '/^\d+\s*\|\s*\d{2}\.\d{2}$/'; // Estructura definida para las predicciones.
        $predictions = array_values(preg_grep($patron, $output));

        if (count($predictions) != 1) {
            return;
        }

        list($labelId, $percentage) = explode("|", $predictions[0]);
        $labelId = trim($labelId);
        $percentage = trim($percentage);

        $label = Label::find($labelId);

        if ($label) {
            $this->predictions[$model->id] = [
                'percentage' => number_format($percentage, 2),
                'name' => $label->name,
                'color' => $label->color,
            ];
        } else {
            $this->predictions[$model->id] = null;
        }
    }
}
