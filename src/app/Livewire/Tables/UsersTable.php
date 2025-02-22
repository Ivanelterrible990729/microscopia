<?php

namespace App\Livewire\Tables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Spatie\Permission\Models\Role;

class UsersTable extends DataTableComponent
{
    protected $model = User::class;

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
            ImageColumn::make(__('Photo'))
                ->location(
                    fn($row) => $row->profile_photo_url
                )
                ->attributes(fn($row) => [
                    'class' => 'w-12 rounded-full mx-auto sm:mx-0',
                    'alt' => $row->name . ' Avatar',
                ]),
            LinkColumn::make(__('Name'))
                ->title(fn($row) => $row->full_name)
                ->location(fn($row) => route('user.show', $row->id))
                ->attributes(fn($row) => [
                    'class' => 'text-blue-700 hover:text-blue-500 underline',
                ])
                ->sortable(
                    fn(Builder $query, string $direction) => $query->orderBy('name', $direction)
                )
                ->searchable(
                    fn(Builder $query, $searchTerm) => $query->orWhere('name', 'like', "%$searchTerm%")
                ),
            Column::make(__("Job title"), "cargo")
                ->sortable()
                ->searchable(),
            Column::make(__("Email"), "email")
                ->sortable(),
            Column::make(__('Roles'))
                ->label(
                    fn($row, Column $column) => implode(', ', $row->roles->pluck('name')->toArray())
                ),
        ];
    }

    public function builder(): Builder
    {
        return User::with('roles')
            ->select([
                'id',
                'profile_photo_path',
                'prefijo',
                'name',
                'cargo',
                'email',
            ]);
    }

    public function filters(): array
    {
        return [
            SelectFilter::make(__('Users'))
            ->options([
                'active' => 'Activos',
                'trashed' => 'Papelera',
            ])->filter(function(Builder $builder, string $value) {
                $value === 'trashed' ? $builder->onlyTrashed() : $builder;
            }),

            MultiSelectFilter::make('Roles')
                ->options(
                Role::query()
                    ->orderBy('name')
                    ->get()
                    ->keyBy('id')
                    ->map(fn($role) => $role->name)
                    ->toArray()
                )
                ->filter(function(Builder $builder, array $values) {
                    $builder->whereHas('roles', function ($query) use ($values) {
                        return $query->whereIn('id', $values);
                    });
                }),
        ];
    }
}
