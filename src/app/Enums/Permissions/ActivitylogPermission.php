<?php

namespace App\Enums\Permissions;

use App\Concerns\Enums\HasPermissions;
use App\Enums\RoleEnum;

enum ActivitylogPermission: string
{
    use HasPermissions;

    case ViewAny = 'activitylog.Ver cualquiera';
    case Clear = 'activitylog.Limpiar';

    public static function map(): array
    {
        return [
            self::ViewAny->value => [RoleEnum::Desarrollador, RoleEnum::Administrador],
            self::Clear->value => [RoleEnum::Desarrollador],
        ];
    }
}
