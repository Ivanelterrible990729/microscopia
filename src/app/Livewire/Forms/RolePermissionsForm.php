<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class RolePermissionsForm extends Form
{
    /**
     * Almacena los permisos seleccionados para el rol especificado.
     */
    public array $selectedPermissions = [];

    protected function rules()
    {
        return [
            'selectedPermissions' => 'array|min:0'
        ];
    }

    protected function messages()
    {
        return [
            'selectedPermissions' => __('Please select the permissions listed below.'),
        ];
    }
}
