<?php

namespace App\Enums\Permissions;

use App\Concerns\Enums\HasPermissions;
use App\Enums\RoleEnum;

enum ActivitylogPermission: string
{
    use HasPermissions;

    case ViewAny = 'activitylog.Ver cualquiera';
    case View = 'activitylog.Ver';
    case Delete = 'activitylog.Eliminar';

    public static function map(): array
    {
        return [
            self::ViewAny->value => [RoleEnum::Desarrollador, RoleEnum::Administrador],
            self::View->value => [RoleEnum::Desarrollador, RoleEnum::Administrador],
            self::Delete->value => [RoleEnum::Desarrollador],
        ];
    }
}
