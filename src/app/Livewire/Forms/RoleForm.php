<?php

namespace App\Livewire\Forms;

use App\Repositories\RoleRepository;
use App\Services\Role\RoleService;
use Livewire\Form;
use Spatie\Permission\Models\Role;

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

    /**
     * Realiza la creación de un rol.
     */
    public function store(): Role
    {
        $this->validate();

        $roleService = new RoleService(new RoleRepository);
        return $roleService->createRole($this->all());
    }

    /**
     * Realiza la actualización de un rol.
     */
    public function update(Role $role): Role
    {
        $this->validate();

        $roleService = new RoleService(new RoleRepository);
        return $roleService->updateRole($role, $this->except('id'));
    }
}
