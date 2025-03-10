<?php

namespace App\Livewire\Forms;

use Livewire\Form;

class RoleForm extends Form
{
    /**
     * ID del rol, sólamente para la edición de roles.
     */
    public null|int $id;

    /**
     * Nombre del rol
     */
    public null|string $name = null;

    /**
     * Guard name del rol
     */
    public string $guard_name = 'web';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:roles,name,'. (isset($this->id) ? $this->id : ''),
            'guard_name' => 'required|string|max:255',
        ];
    }

    protected function validationAttributes()
    {
        return [
            'name' => __('Role name'),
            'guard_name' => __('Guard name')
        ];
    }
}
