<?php

namespace App\Livewire\Activity;

use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class ShowActivityDetail extends Component
{
    public null|Activity $activity = null;

    #[On('show-activity-details')]
    public function loadActivity(string $activityId)
    {
        $this->activity = Activity::find($activityId);
        $this->modal('slide-activity-details')->show();
    }

    public function render()
    {
        return view('livewire.activity.show-activity-detail');
    }

    #[On('activities-cleared')]
    public function refreshComponent()
    {
        $this->reset('activity');
    }
}
