<?php

namespace App\Enums\Permissions;

use App\Concerns\Enums\HasPermissions;
use App\Enums\RoleEnum;

enum labelPermission: string
{
    use HasPermissions;

    case Upload = 'label.Crear';
    case Update = 'label.Editar';
    case Delete = 'label.Eliminar';

    public static function map(): array
    {
        return [
            self::Upload->value => [RoleEnum::Desarrollador, RoleEnum::JefeUnidad],
            self::Update->value => [RoleEnum::Desarrollador, RoleEnum::JefeUnidad],
            self::Delete->value => [RoleEnum::Desarrollador, RoleEnum::JefeUnidad],
        ];
    }
}
