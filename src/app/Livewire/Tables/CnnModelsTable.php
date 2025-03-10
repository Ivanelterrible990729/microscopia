<?php

namespace App\Livewire\Tables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\CnnModel;
use App\Models\Label;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;

class CnnModelsTable extends DataTableComponent
{
    protected $model = CnnModel::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setTheadAttributes([
            'class' => 'hidden sm:table-header-group',
        ]);

        $this->setTdAttributes(function(Column $column, $row, $columnIndex, $rowIndex) {
            return [
                'class' => 'max-w-[16rem] truncate hover:whitespace-normal',
            ];
        });
    }

    public function columns(): array
    {
        return [
            LinkColumn::make(__('Name'))
                ->title(fn($row) => $row->name)
                ->location(fn($row) => route('cnn-model.show', $row->id))
                ->attributes(fn($row) => [
                    'class' => 'text-blue-700 hover:text-blue-500 dark:text-blue-500 dark:hover:text-blue-700 underline',
                ])
                ->sortable(
                    fn(Builder $query, string $direction) => $query->orderBy('name', $direction)
                )
                ->searchable(
                    fn(Builder $query, $searchTerm) => $query->orWhere('name', 'like', "%$searchTerm%")
                ),
            Column::make(__('Model loaded'))
                ->label(fn ($row, Column $column) => $this->getMediaStatus($row))
                ->html(),
            Column::make(__('Labels'))
                ->label(
                fn($row, Column $column) => implode(', ', $row->labels->pluck('name')->toArray())
                ),
            Column::make(__("Created at"), "created_at")
                ->sortable(),
            Column::make(__("Updated at"), "updated_at")
                ->sortable(),
        ];
    }

    public function builder(): Builder
    {
        return CnnModel::with('labels')
            ->select([
                'id',
                'name',
                'created_at',
                'updated_at'
            ]);
    }

    public function filters(): array
    {
        return [
            MultiSelectFilter::make(__('Labels'))
                ->options(
                Label::query()
                    ->orderBy('name')
                    ->get()
                    ->keyBy('id')
                    ->map(fn($label) => $label->name)
                    ->toArray()
                )
                ->filter(function(Builder $builder, array $values) {
                    $builder->whereHas('labels', function ($query) use ($values) {
                        return $query->whereIn('labels.id', $values);
                    });
                }),
        ];
    }

    private function getMediaStatus(CnnModel $cnnModel): string
    {
        return $cnnModel->hasMedia('*')
            ? '<span class="text-green-500">' . __('Loaded') .'</span> '
            : '<span class="text-red-500">'. __('Not loaded') . '</span>';
    }
}
