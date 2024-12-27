<?php

namespace App\Enums\Permissions;

use App\Concerns\Enums\HasPermissions;
use App\Enums\RoleEnum;

enum RolePermission: string
{
    use HasPermissions;

    case View = 'role.ver';
    case Create = 'role.crear';
    case Update = 'role.editar';
    case Delete = 'role.eliminar';

    public static function map(): array
    {
        return [
            self::View->value => [RoleEnum::Desarrollador],
            self::Create->value => [RoleEnum::Desarrollador],
            self::Update->value => [RoleEnum::Desarrollador],
            self::Delete->value => [RoleEnum::Desarrollador],
        ];
    }
}
