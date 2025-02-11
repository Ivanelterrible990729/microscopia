<?php

namespace App\View\Components\Label;

use App\Models\Label;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ShowLabels extends Component
{
    /**
     * Etiquetas a mostrar en el renderizado.
     */
    public array $labels;

    /**
     * Create a new component instance.
     */
    public function __construct(array $labelIds)
    {
        $this->labels = Label::whereIn('id', $labelIds)->get()->map(function($label) {
            return [
                'id' => $label->id,
                'name' => $label->name,
                'color' => $label->color,
            ];
        })->toArray();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.label.show-labels');
    }
}
