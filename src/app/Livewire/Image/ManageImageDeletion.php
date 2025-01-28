<?php

namespace App\Livewire\Image;

use App\Models\Image;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class ManageImageDeletion extends Component
{
    /**
     * Indica el modo de eliminación
     */
    public string $mode = 'images-deleted';

    /**
     * IDs de las imagenes a eliminar.
     */
    public array $imageIds = [];

    /**
     * Catálogo de los permisos existentes en el sistema agroupados por su prefijo.
     */
    #[Computed]
    public function numImages()
    {
        return count($this->imageIds);
    }

    protected function rules()
    {
        return [
            'imageIds' => 'array|min:1',
            'imageIds.*' => 'numeric|exists:images,id',
        ];
    }

    protected function messages()
    {
        return [
            'imageIds' => __('You must select at least one image.'),
            'imageIds.*' => __('The selected images must exist.'),
        ];
    }

    public function render()
    {
        return view('livewire.image.manage-image-deletion');
    }

    /**
     *  Abre del modal en modo eliminación.
     */
    #[On('delete-images')]
    public function openModalDelete($imageIds)
    {
        $this->imageIds = explode(',', $imageIds);
        $this->mode = 'images-deleted';

        $this->modal('modal-manage-image-deletion')->show();
    }

    /**
     *  Abre del modal en modo restauracón.
     */
    #[On('restore-images')]
    public function opdenModalRestore($imageIds)
    {
        $this->imageIds = explode(',', $imageIds);
        $this->mode = 'images-restored';

        $this->modal('modal-manage-image-deletion')->show();
    }

    /**
     * Realiza la acción indicada.
     */
    public function performAction()
    {
        $this->validate();

        $query = Image::withTrashed()->whereIn('id', $this->imageIds);
        $numImages = $this->mode == 'images-deleted' ? $query->delete() : $query->restore();

        $this->dispatch($this->mode, numImages: $numImages);
        $this->modal('modal-manage-image-deletion')->hide();
    }
}
