<?php

namespace App\Livewire\Listados;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Spatie\Permission\Models\Role;

class RolesTable extends DataTableComponent
{
    protected $model = Role::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setTheadAttributes([
            'class' => 'hidden sm:table-header-group',
        ]);
    }

    public function columns(): array
    {
        return [
            LinkColumn::make('Id')
                ->title(fn($row) => $row->id)
                ->location(fn($row) => route('roles.show', $row->id))
                ->attributes(fn($row) => [
                    'class' => 'text-blue-700 hover:text-blue-500 underline',
                ])
                ->sortable(
                    fn(Builder $query, string $direction) => $query->orderBy('id', $direction)
                )
                ->searchable(
                    fn(Builder $query, $searchTerm) => $query->orWhere('id', 'like', "%$searchTerm%")
                ),
            Column::make("Name", "name")
                ->sortable()
                ->searchable(),
            Column::make(__("Created at"), "created_at")
                ->sortable(),
            Column::make(__("Updated at"), "updated_at")
                ->sortable(),
        ];
    }

    public function builder(): Builder
    {
        return Role::query()
            ->select([
                'id',
                'name',
                'created_at',
                'updated_at'
            ]);
    }
}
