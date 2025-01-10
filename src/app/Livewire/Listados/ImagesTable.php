<?php

namespace App\Livewire\Listados;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Image;
use App\Models\Label;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;

class ImagesTable extends DataTableComponent
{
    protected $model = Image::class;

    /**
     * Catálogo de los permisos existentes en el sistema agroupados por su prefijo.
     */
    #[Computed]
    public function labels()
    {
        return Label::query()
            ->select([
                'id',
                'name',
                'color',
                'number_images'
            ])->get();
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setConfigurableArea('before-tools', 'livewire.image.images-table');

        $this->setTableWrapperAttributes([
            'x-show' => 'show',
        ]);

        $this->setColumnSelectDisabled();
        $this->setToolsDisabled();
        $this->setPaginationVisibilityDisabled();
        $this->setPerPageAccepted([12, 24, 48, 96]);
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
        ];
    }

    public function builder(): Builder
    {
        return Image::with(['labels', 'user'])
            ->orderBy('created_at', 'desc')
            ->select([
                'id',
                'user_id',
                'name',
                'created_at'
            ]);
    }
}
