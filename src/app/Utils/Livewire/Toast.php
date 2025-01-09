<?php

namespace App\Utils\Livewire;

use Livewire\Component;

class Toast
{
    protected string $type = '';

    public function __construct(
        protected   Component $wire,
        public      ?string $title = null,
        public      ?string $message = null,
    ) {
    }

    public function success(): void
    {
        $this->fire('success-notification');
    }

    public function warning(): void
    {
        $this->fire('warning-notification');
    }

    public function danger(): void
    {
        $this->fire('error-notification');
    }

    public function info(): void
    {
        $this->fire('info-notification');
    }

    protected function fire(string $type): void
    {
        $toast = [
            'id' => $type,
            'message' => $this->message,
        ];

        if ($this->title !== null) {
            $toast['title'] = $this->title;
        }

        $this->wire->dispatch('toastify-js', $toast);
    }

    public static function registerMethod(): void
    {
        Component::macro('toast', function (?string $title = null, ?string $message = null): Toast {
            return new Toast($this, $title, $message);
        });
    }
}
