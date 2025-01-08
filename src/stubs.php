<?php
/*
|--------------------------------------------------------------------------
| Macros
|--------------------------------------------------------------------------
|
| Para que el IDE pueda dar código de ayuda con las macros registradas.
|
*/

namespace Livewire
{
    use App\Utils\Livewire\Modal;
    use App\Utils\Livewire\Toast;

    class Component
    {
        /**
         * Permite controlar el modal con el ID especificado.
         * @param string $modalId
         * @return Modal
         */
        public function modal(string $id): Modal {}

        /**
         * Define un toast que se puede llamar más tarde.
         * @param string|null $title
         * @param string|null $message
         * @return Toast
         */
        public function toast(?string $title = null, ?string $message = null): Toast {}
    }
}
