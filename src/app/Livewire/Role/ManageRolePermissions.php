<?php

namespace App\Livewire\Role;

use App\Enums\Permissions\RolePermission;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ManageRolePermissions extends Component
{
    /**
     * Rol definido para calcular los permisos seleccionados
     */
    public Role $role;

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

    /**
     * Relaciona los permisos al rol especificado
     */
    public function storePermissions()
    {
        $this->validate(rules: [
            'selectedPermissions' => 'array|min:0'
        ], messages: [
            'selectedPermissions' => __('Please select the permissions listed below.'),
        ]);

        if (request()->user()->cannot(RolePermission::ManagePermissions)) {
            $this->addError('autorization', __('You do not have permissions to perform this action.'));
            return;
        }

        $this->role->syncPermissions($this->selectedPermissions);

        return redirect()->route('role.show', $this->role)->with([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The permissions have been successfully related.')
            ]
        ]);
    }
}
