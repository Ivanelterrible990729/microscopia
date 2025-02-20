<?php

namespace App\Livewire\CnnModel;

use App\Enums\Media\MediaEnum;
use App\Models\CnnModel;
use App\Services\TrainModelService;
use Livewire\Attributes\On;
use Livewire\Component;

class InfoCnnModel extends Component
{
    /**
     * Referencia del modelo al cual mostrar la info.
     */
    public CnnModel $cnnModel;

    /**
     * Determina si el usuario tiene permisos para eliminar el modelo.
     */
    public bool $canDeleteModel;

    /**
     * Determina si el usuario tiene permisos para editar el modelo.
     */
    public bool $canUpdateModel;

        /**
     * Determina si el usuario tiene permisos para descargar el modelo.
     */
    public bool $canDownloadModel;

    public function mount(CnnModel $cnnModel, bool $canDownloadModel, bool $canUpdateModel, bool $canDeleteModel)
    {
        $this->cnnModel = $cnnModel;
        $this->canDownloadModel = $canDownloadModel;
        $this->canUpdateModel = $canUpdateModel;
        $this->canDeleteModel = $canDeleteModel;
    }

    public function render()
    {
        return view('livewire.cnn-model.info-cnn-model');
    }

    /**
     * Realiza la descarga del modelo por medio de TrainModelService.
     */
    public function downloadModel()
    {
        if (!$this->canDeleteModel) {
            $this->toast(title: __('Error'), message:  __('You do not have permissions to perform this action.'))->danger();
            return;
        }

        return TrainModelService::downloadModel($this->cnnModel->getFirstMedia(MediaEnum::CNN_Model->value));
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
