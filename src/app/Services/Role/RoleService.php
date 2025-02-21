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
        return $this->roleRepository->create($data);
    }

    /**
     * Proceso de actualización de un rol.
     */
    public function updateRole(Role $role, array $data): Role
    {
        return $this->roleRepository->update($role, $data);
    }

    /**
     * Proceso de eliminación de un rol.
     */
    public function deleteRole(Role $role): void
    {
        $this->roleRepository->delete($role);
    }

    /**
     * Sincronización de permisos de un rol.
     */
    public function syncPermissions(Role $role, array $permissionNames): void
    {
        $this->roleRepository->syncPermissions($role, $permissionNames);
    }
}
