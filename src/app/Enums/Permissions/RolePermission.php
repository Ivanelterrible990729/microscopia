<?php

namespace App\Enums\Permissions;

use App\Concerns\Enums\HasPermissions;

enum RolePermission: string
{
    use HasPermissions;

    case Ver = 'role.ver';
    case Crear = 'role.crear';
    case Editar = 'role.editar';
    case Eliminar = 'role.elimminar';

    public static function map(): array
    {
        return [
            self::Ver->value => ['Desarrollador'],
            self::Crear->value => ['Desarrollador'],
            self::Editar->value => ['Desarrollador'],
            self::Eliminar->value => ['Desarrollador'],
        ];
    }
}
