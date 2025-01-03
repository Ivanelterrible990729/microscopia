<?php

namespace App\Enums\Permissions;

use App\Concerns\Enums\HasPermissions;
use App\Enums\RoleEnum;

enum RolePermission: string
{
    use HasPermissions;

    case ViewAny = 'role.ver-cualquiera';
    case View = 'role.ver';
    case Create = 'role.crear';
    case Update = 'role.editar';
    case Delete = 'role.eliminar';
    case ManagePermissions = 'role.administrar-permisos';
    case AssignRoles = 'role.asignar-roles';

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
