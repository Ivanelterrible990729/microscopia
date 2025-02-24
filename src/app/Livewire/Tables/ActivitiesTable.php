<?php

namespace App\Livewire\Tables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
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

    public function filters(): array
    {
        return [
            DateRangeFilter::make(__('Date range'))
                ->setFilterPillValues([0 => 'minDate', 1 => 'maxDate']) // The values that will be displayed for the Min/Max Date Values
                ->setFilterDefaultValue(['minDate' => now()->subWeek()->format('Y-m-d'), 'maxDate' => date('Y-m-d')])
                ->config([
                    'altFormat' => 'F j, Y', // Date format that will be displayed once selected
                    'ariaDateFormat' => 'F j, Y', // An aria-friendly date format
                    'dateFormat' => 'Y-m-d', // Date format that will be received by the filter
                    'latestDate' => date('Y-m-d'), // The latest acceptable date
                    'placeholder' => __('Enter date range'), // A placeholder value
                    'locale' => 'es_ES',
                ])
                ->filter(function (Builder $builder, array $dateRange) { // Expects an array.
                    $builder
                        ->whereDate(config('activitylog.table_name') . '.created_at', '>=', $dateRange['minDate']) // minDate is the start date selected
                        ->whereDate(config('activitylog.table_name') . '.created_at', '<=', $dateRange['maxDate']); // maxDate is the end date selected
                }),

            SelectFilter::make(__('Users'))
                ->options([
                    '' => __('All'),
                ] + User::orderBy('name', 'asc')->get()->pluck('name', 'id')->toArray())
                ->filter(function(Builder $builder, string $value) {
                    $builder->where('causer_id', $value);
                }),
        ];
    }

    #[On('activities-cleared')]
    public function refreshComponent($message)
    {
        $this->toast(__('Success'), $message)->success();
        $this->render();
    }
}
