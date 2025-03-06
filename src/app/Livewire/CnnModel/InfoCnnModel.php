<?php

namespace App\Livewire\CnnModel;

use App\Enums\Media\MediaEnum;
use App\Models\CnnModel;
use App\Services\TrainModelService;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\Component;

class InfoCnnModel extends Component
{
    /**
     * Referencia del modelo al cual mostrar la info.
     */
    public CnnModel $cnnModel;

    public function mount(CnnModel $cnnModel)
    {
        $this->cnnModel = $cnnModel;
    }

    public function render()
    {
        return view('livewire.cnn-model.info-cnn-model');
    }

    /**
     * Realiza la descarga del modelo por medio de TrainModelService.
     */
    public function downloadModel(TrainModelService $trainModelService)
    {
        Gate::authorize('delete', $this->cnnModel);

        return $trainModelService->downloadModel($this->cnnModel->getFirstMedia(MediaEnum::CNN_Model->value));
    }

    /**
     * Refrezca el contenido del modelo para actualizarlo en la vista.
     */
    #[On('refresh-model')]
    public function refreshModel()
    {
        $this->cnnModel->refresh();
    }
}
