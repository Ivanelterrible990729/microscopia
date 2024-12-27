<?php

namespace App\Livewire\Role;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
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

        $this->setTrAttributes(function($row, $index) {
            return [
                'class' => 'border border-b-2 sm:border-b-0',
            ];
        });
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Name", "name")
                ->sortable(),
            Column::make(__("Created at"), "created_at")
                ->sortable(),
            Column::make(__("Updated at"), "updated_at")
                ->sortable(),
        ];
    }
}
