<?php

namespace App\Repositories;

use Spatie\Permission\Models\Role;

class RoleRepository
{
    /**
     * Crea un registro Role en la base de datos
     */
    public function create(array $data): Role
    {
        return Role::create($data);
    }

    /**
     * Actualiza un registro Role en la base de datos
     */
    public function update(Role $role, array $data): Role
    {
        $role->update($data);
        return $role;
    }

    /**
     * Elimina un registro Role en la base de datos
     */
    public function delete(Role $role): void
    {
        $role->delete();
    }

    /**
     * Sincroniza los permisos de un rol en la base de datos.
     */
    public function syncPermissions(Role $role, array $permissionNames): void
    {
        $role->syncPermissions($permissionNames);
    }
}
