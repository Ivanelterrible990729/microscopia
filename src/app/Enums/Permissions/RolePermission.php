<?php

namespace App\Enums\Permissions;

use App\Concerns\Enums\HasPermissions;
use App\Enums\RoleEnum;

enum RolePermission: string
{
    use HasPermissions;

    case ViewAny = 'role.Ver cualquiera';
    case View = 'role.Ver';
    case Create = 'role.Crear';
    case Update = 'role.Editar';
    case Delete = 'role.Eliminar';
    case ManagePermissions = 'role.Administrar permisos';
    case AssignRoles = 'role.Asignar roles';

    public static function map(): array
    {
        return [
            self::ViewAny->value => [RoleEnum::Desarrollador],
            self::View->value => [RoleEnum::Desarrollador],
            self::Create->value => [RoleEnum::Desarrollador],
            self::Update->value => [RoleEnum::Desarrollador],
            self::Delete->value => [RoleEnum::Desarrollador],
            self::ManagePermissions->value => [RoleEnum::Desarrollador],
            self::AssignRoles->value => [RoleEnum::Desarrollador],
        ];
    }
}
