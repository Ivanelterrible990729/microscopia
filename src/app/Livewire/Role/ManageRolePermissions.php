<?php

namespace App\Livewire\Role;

use App\Livewire\Forms\RolePermissionsForm;
use App\Services\RoleService;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ManageRolePermissions extends Component
{
    /**
     * Form para la edición del rol.
     */
    public RolePermissionsForm $form;

    /**
     * Rol definido para calcular los permisos seleccionados
     */
    public Role $role;

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
        $this->form->selectedPermissions = $this->role->permissions->pluck('name')->toArray();
    }

    public function render()
    {
        return view('livewire.role.manage-role-permissions');
    }

    /**
     * Relaciona los permisos al rol especificado
     */
    public function storePermissions(RoleService $roleService)
    {
        Gate::authorize('managePermissions', $this->role);
        $this->validate();

        $roleService->syncPermissions($this->role, $this->form->selectedPermissions);

        return redirect()->route('role.show', $this->role)->with([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The permissions have been successfully related.')
            ]
        ]);
    }
}
