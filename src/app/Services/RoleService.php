<?php

namespace App\Services;

use App\Contracts\Services\ActivityInterface;
use App\Repositories\RoleRepository;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function __construct(
        protected RoleRepository $roleRepository,
        protected ActivityInterface $activityService
    ) {}

    /**
     * Proceso de registro de un rol.
     */
    public function createRole(array $data): Role
    {
        $role = $this->roleRepository->create($data);

        $this->activityService->logActivity(
            logName: __('Roles'),
            performedOn: $role,
            properties: $role->getAttributes(),
            description: __('Role created.')
        );

        return $role;
    }

    /**
     * Proceso de actualización de un rol.
     */
    public function updateRole(Role $role, array $data): Role
    {
        $this->activityService->setOldProperties($role->getAttributes());

        $role = $this->roleRepository->update($role, $data);

        $this->activityService->logActivity(
            logName: __('Roles'),
            performedOn: $role,
            properties: $role->getAttributes(),
            description: __('Role updated.')
        );

        return $role;
    }

    /**
     * Proceso de eliminación de un rol.
     */
    public function deleteRole(Role $role): void
    {
        $this->roleRepository->delete($role);

        $this->activityService->logActivity(
            logName: __('Roles'),
            performedOn: $role,
            properties: $role->getAttributes(),
            description: __('Role deleted.')
        );
    }

    /**
     * Sincronización de permisos de un rol.
     */
    public function syncPermissions(Role $role, array $permissionNames): void
    {
        $this->activityService->setOldProperties($role->permissions->pluck('name', 'id')->toArray());

        $this->roleRepository->syncPermissions($role, $permissionNames);

        $this->activityService->logActivity(
            logName: __('Roles'),
            performedOn: $role,
            properties: $role->permissions->pluck('name', 'id')->toArray(),
            description: __('Permission assigned.')
        );
    }
}
