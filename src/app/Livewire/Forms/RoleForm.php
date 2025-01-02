<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Spatie\Permission\Models\Role;

class RoleForm extends Form
{
    /**
     * Formulario a utilizar para los formularios de roles.
     */
    public array $role;

    /**
     * Modelo de referencia del rol a editar.
     */
    public ?Role $roleModel;

    protected function rules()
    {
        return [
            'role.name' => 'required|string|max:255|unique:roles,name,'. (isset($this->role['id']) ? $this->role['id'] : ''),
            'role.guard_name' => 'required|string|max:255',
        ];
    }

    protected function validationAttributes()
    {
        return [
            'role.name' => __('Role name'),
            'role.guard_name' => __('Guard name')
        ];
    }

    public function update()
    {
        $this->validate();
        $this->roleModel->update([$this->role]);

        return $this->roleModel->refresh();
    }
}
