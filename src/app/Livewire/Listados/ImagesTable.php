<?php

namespace App\Livewire\Listados;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Image;
use App\Models\Label;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class ImagesTable extends DataTableComponent
{
    protected $model = Image::class;

    /**
     *  Acumula las imagenes seleccionadas por Ids.
     */
    public array $selectedImages = [];

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

        $this->setConfigurableAreas([
            'before-tools' => 'livewire.image.images-table',
            'toolbar-left-end' => 'livewire.image.partials.select-all-button',
        ]);

        $this->setTableWrapperAttributes([
            'x-show' => '!showGrid',
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

    public function filters(): array
    {
        return [
            SelectFilter::make(__('Images'))
                ->options([
                    'active' => 'Activas',
                    'trashed' => 'Papelera',
                ])->filter(function(Builder $builder, string $value) {
                    $value === 'trashed' ? $builder->onlyTrashed() : $builder;
                }),
            MultiSelectFilter::make(__('Labels'))
                ->options(
                    [
                        'unlabeled' => 'Sin etiquetar',
                    ] +
            $this->labels
                        ->keyBy('id')
                        ->map(fn($label) => $label->name)
                        ->toArray()
                )
                ->filter(function(Builder $builder, array $values) {

                    $builder = $builder->whereHas('labels', function ($query) use ($values) {
                        return $query->whereIn('image_label.label_id', $values);
                    });

                    if (in_array('unlabeled', $values)) {
                        $builder = $builder->orWhere(function ($builder) {
                            $builder->whereDoesntHave('labels');
                        });
                    }

                    return $builder;
                }),
        ];
    }

    public function setFilterImages(string $value): void
    {
        dd($this->selectedImages);
        $this->setFilter(uncamelize(__('Images')), $value == 'active' ? null : $value);
    }

    public function setFilterLabels(string $labelId): void
    {
        $filterLabels = $this->filterComponents[uncamelize(__('Labels'))];

        if (!in_array($labelId, $filterLabels)) {
            $updatedFilters = array_merge($filterLabels, [$labelId]);
        } else {
            $updatedFilters = array_diff($filterLabels, [$labelId]);
        }

        $this->setFilter(uncamelize(__('Labels')), $updatedFilters);
    }
}
