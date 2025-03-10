<?php

namespace App\View\Components\Activity;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SubjectLink extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public null|string $subjectId,
        public null|string $subjectType,
        public bool $link = false,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $route = null;
        $value = null;

        if (is_null($this->subjectType)) {
            $value = __("No subject.");
        } else {
            switch ($this->subjectType) {
                case 'Spatie\Permission\Models\Role':
                    $route =  route('role.show', $this->subjectId);
                    $value = __('Role');
                    break;

                case 'App\Models\User':
                    $route = route('user.show', $this->subjectId);
                    $value = __('User');
                    break;

                case 'App\Models\CnnModel':
                    $route = route('cnn-model.show', $this->subjectId);
                    $value = __('CNN Model');
                    break;

                case 'App\Models\Image':
                    $route = route('image.show', $this->subjectId);
                    $value = __('Image');
                    break;

                case 'App\Models\Label':
                    $value = __('Label');
                    break;

                default:
                    $value = ltrim(strrchr($this->subjectType, '\\'), '\\');
                    break;
            }

            if ($this->link) {
                $modelExists = app($this->subjectType)->whereId($this->subjectId)->exists();
                if (! $modelExists) {
                    $route = null;
                }
            }

            $value .= ': ' . $this->subjectId;
        }

        return view('components.activity.subject-link', [
            'tag' => ($this->link && isset($route)) ? 'a' : 'span',
            'route' => $route,
            'value' => $value,
        ]);
    }
}
