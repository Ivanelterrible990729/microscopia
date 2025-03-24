<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\User;

class DocumentationPolicy
{
    /**
     * Verifica que el usuario tenga permisos para ver la documentacion.
     */
    public function show(?User $user, $documentation)
    {
        if ($user && $documentation->version == 'desarrollador') {
            return $user->hasRole(RoleEnum::Desarrollador->value);
        }

        return true;
    }
}
