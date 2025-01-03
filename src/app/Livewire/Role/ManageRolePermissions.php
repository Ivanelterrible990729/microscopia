<?php

namespace App\Livewire\Role;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ManageRolePermissions extends Component
{
    /**
     * Rol definido para calcular los permisos seleccionados
     */
    protected Role $role;

    /**
     * Almacena los permisos seleccionados para el rol especificado.
     */
    public array $selectedPermissions;

    /**
     * Catálogo de los permisos existentes en el sistema agroupados por su prefijo.
     */
    #[Computed]
    public function groupedPermissions()
    {
        return Permission::all()->map(function($permission) {
            $permissionName = $permission->name;
            $dotPosition = strpos($permissionName, '.');
            return $permission->getAttributes() + [
                'prefix' => $dotPosition === false
                    ? $permissionName
                    : substr($permissionName, 0, $dotPosition),
                'subfix' => $dotPosition === false
                    ? $permissionName
                    : substr($permissionName, $dotPosition + 1)
            ];
        })->groupBy('prefix');
    }

    public function mount(Role $role)
    {
        $this->role = $role;

        $this->selectedPermissions = $this->role->permissions->pluck('name')->toArray();
    }

    public function render()
    {
        return view('livewire.role.manage-role-permissions');
    }

    public function storePermissions()
    {
        dd($this->selectedPermissions);
    }
}
