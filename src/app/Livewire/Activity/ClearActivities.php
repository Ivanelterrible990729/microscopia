<?php

namespace App\Livewire\Activity;

use App\Enums\Permissions\ActivitylogPermission;
use Illuminate\Support\Facades\Artisan;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class ClearActivities extends Component
{
    public string $logName = '';
    public int $numDays;

    public function mount()
    {
        $this->numDays = config('activitylog.delete_records_older_than_days');
    }

    public function render()
    {
        return view('livewire.activity.clear-activities');
    }

    public function clearActivities()
    {
        if (request()->user()->cannot(ActivitylogPermission::Clear)) {
            $this->toast(__('Error'), __("You do not have permissions to perform this action."))->danger();
            return;
        }

        $command = 'activitylog:clean --force' . ' --days=' . $this->numDays;

        if (Activity::where('log_name', $this->logName)->exists()) {
            $command .= ' ' . $this->logName;
        } else if ($this->logName != '') {
            $this->toast(__('Error'), __("The specified module doesn't exists."))->danger();
            return;
        }

        Artisan::call($command);
        $this->reset(['logName']);
        $this->numDays = config('activitylog.delete_records_older_than_days');

        $message = __('The activity log has been successfully deleted.');

        $this->dispatch('activities-cleared', message: $message);
        $this->modal('modal-clear-activities')->hide();
    }
}
