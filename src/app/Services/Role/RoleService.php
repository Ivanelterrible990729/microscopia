<?php

namespace App\Services\Role;

use App\Repositories\RoleRepository;
use Spatie\Permission\Models\Role;

class RoleService
{
    /**
     * Repositorio de Role.
     */
    public function __construct(protected RoleRepository $roleRepository) {}

    /**
     * Proceso de registro de un rol.
     */
    public function createRole(array $data): Role
    {
        $role = $this->roleRepository->create($data);

        activity('Roles')
            ->performedOn($role)
            ->withProperties($role->getAttributes())
            ->log(__("created"));

        return $role;
    }

    /**
     * Proceso de actualización de un rol.
     */
    public function updateRole(Role $role, array $data): Role
    {
        $oldValues = $role->getAttributes();

        $role = $this->roleRepository->update($role, $data);

        activity('Roles')
            ->performedOn($role)
            ->withProperties([
                'attributes' => $role->getAttributes(),
                'old' => $oldValues,
            ])
            ->log(__("updated"));

        return $role;
    }

    /**
     * Proceso de eliminación de un rol.
     */
    public function deleteRole(Role $role): void
    {
        $this->roleRepository->delete($role);

        activity('Roles')
            ->performedOn($role)
            ->withProperties($role->getAttributes())
            ->log(__("deleted"));
    }

    /**
     * Sincronización de permisos de un rol.
     */
    public function syncPermissions(Role $role, array $permissionNames): void
    {
        $this->roleRepository->syncPermissions($role, $permissionNames);
    }
}
