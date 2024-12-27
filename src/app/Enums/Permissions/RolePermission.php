<?php

namespace App\Enums\Permissions;

use App\Concerns\Enums\HasPermissions;
use App\Enums\RoleEnum;

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
            self::Ver->value => [RoleEnum::Desarrollador],
            self::Crear->value => [RoleEnum::Desarrollador],
            self::Editar->value => [RoleEnum::Desarrollador],
            self::Eliminar->value => [RoleEnum::Desarrollador],
        ];
    }
}
