<?php

namespace App\Policies;

use App\Models\User;

class DocumentationPolicy
{
    /**
     * Verifica que el usuario tenga permisos para ver la documentacion.
     */
    public function show(?User $user, $documentation)
    {
        return true;
    }
}
