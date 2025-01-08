<?php

namespace App\Utils\Livewire;

use Livewire\Component;

class Modal
{
    public function __construct(
        protected   Component $wire,
        public      string|int $modalId,
    ) {
    }

    protected function dispatch(string $action = null): void
    {
        $data = [
            'id' => $this->modalId,
        ];

        if ($action) {
            $data['action'] = $action;
        }

        $this->wire->dispatch("toggle-modal", $data);
    }

    /**
     * Cambia el estado del modal al opuesto.
     */
    public function toggle(): void
    {
        $this->dispatch();
    }

    /**
     * Muestra el modal
     */
    public function show(): void
    {
        $this->dispatch('show');
    }

    /**
     * Muestra el modal
     */
    public function hide(): void
    {
        $this->dispatch('hide');
    }

    /**
     * Registra el método _modal_ en los componentes de Livewire.
     */
    public static function registerMethod(): void
    {
        Component::macro('modal', function (string|int $id): Modal {
            return new Modal($this, $id);
        });
    }
}
