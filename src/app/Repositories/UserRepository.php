<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * Realiza la sincronización de roles en BD.
     */
    public function syncRoles(User $user, array $roles): void
    {
        $user->syncRoles($roles);
    }

    /**
     * Elimina un registro User en la base de datos (softDelete)
     */
    public function delete(User $user): void
    {
        $user->delete();
    }

    /**
     * Restaura la inactividad del usuario (Elimina softdelete)
     */
    public function restore(User $user): void
    {
        $user->restore();
    }
}
