<?php

namespace App\Concerns\Tests;

use App\Models\User;
use BackedEnum;
use Spatie\Permission\Models\Role;

trait CustomMethods
{
    /**
     * Retorna usuario(s) ya sea buscado o creado
     */
    public function getUser(BackedEnum|string $role, bool $create = false, int $quantity = 1): mixed
    {
        if ($create) {
            $users = User::factory($quantity)
                ->create();

            foreach ($users as $user) $user->assignRole($role);

            return $users->count() > 1 ? $users : $users->first();
        } else {
            return User::whereHas('roles', function ($query) use ($role) {
                return $query->where('name', $role);
            })->first();
        }
    }

    /**
     *  Asigna un permiso al rol especificado.
     */
    public function giveRolePermissionTo(string $roleName, BackedEnum|string|array $permissions): void
    {
        $role = Role::findByName($roleName, 'web')
            ->givePermissionTo($permissions);

        $role->refresh();
    }

    /**
     *  Elimina un permiso al rol especificado.
     */
    public function revokeRolePermissionTo(string $roleName, BackedEnum|string|array $permissions): void
    {
        $role = Role::findByName($roleName, 'web')
            ->revokePermissionTo($permissions);

        $role->refresh();
    }
}
