<?php

namespace App\View\Components\Activity;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CauserLink extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public null|string $causerId,
        public bool $link = false,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $route = null;
        $value = null;

        if (is_null($this->causerId)) {
            $value = '[System]';
        } else {
            $user = User::withTrashed()->find($this->causerId);

            if (isset($user)) {
                $route = route('user.show', $this->causerId);
                $value = $user->full_name;
            } else {
                $route = null;
                $value = __('User') . ': ' . $this->causerId;
            }
        }

        return view('components.activity.causer-link', [
            'tag' => ($this->link && isset($route)) ? 'a' : 'span',
            'route' => $route,
            'value' => $value,
        ]);
    }
}
