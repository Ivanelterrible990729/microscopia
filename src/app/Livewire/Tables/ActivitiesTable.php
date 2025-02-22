<?php

namespace App\Livewire\Tables;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Spatie\Activitylog\Models\Activity;

class ActivitiesTable extends DataTableComponent
{
    protected $model = Activity::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->view('livewire.tables.activities-table.slide-button'),
            Column::make(__("Date and time"), "created_at")
                ->sortable(),
            Column::make(__('Causer'), 'causer_id')
                ->format(fn ($value, $row) => $row->causer->full_name ?? '[SYSTEM]'),
            Column::make(__('Module'), "log_name")
                ->searchable()
                ->sortable(),
            Column::make(__('Subject'), "subject_type")
                ->view('livewire.tables.activities-table.subject-link'),
            Column::make(__('Description'), "description")
                ->searchable()
                ->sortable(),
        ];
    }

    public function builder(): Builder
    {
        return Activity::with(['subject', 'causer'])
            ->orderBy('created_at','desc')
            ->select([
                'id',
                'log_name',
                'description',
                'subject_id',
                'subject_type',
                'causer_id',
                'causer_type',
            ]);
    }

    #[On('activities-cleared')]
    public function refreshComponent($message)
    {
        $this->toast(__('Success'), $message)->success();
        $this->render();
    }
}
