<?php

namespace App\Enums\Permissions;

use App\Concerns\Enums\HasPermissions;
use App\Enums\RoleEnum;

enum UserPermission: string
{
    use HasPermissions;

    case ViewAny = 'user.Ver cualquiera';
    case View = 'user.Ver';
    case Create = 'user.Crear';
    case Personify = 'user.Personificar';
    case Delete = 'user.Eliminar';
    case AssignRoles = 'user.Asignar roles';

    public static function map(): array
    {
        return [
            self::ViewAny->value => [RoleEnum::Desarrollador, RoleEnum::Administrador],
            self::View->value => [RoleEnum::Desarrollador, RoleEnum::Administrador],
            self::Create->value => [RoleEnum::Desarrollador, RoleEnum::Administrador],
            self::Personify->value => [RoleEnum::Desarrollador],
            self::Delete->value => [RoleEnum::Desarrollador],
            self::AssignRoles->value => [RoleEnum::Desarrollador, RoleEnum::Administrador],
        ];
    }
}
