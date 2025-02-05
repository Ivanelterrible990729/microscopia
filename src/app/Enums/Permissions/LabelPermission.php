<?php

namespace App\Enums\Permissions;

use App\Concerns\Enums\HasPermissions;
use App\Enums\RoleEnum;

enum LabelPermission: string
{
    use HasPermissions;

    case Create = 'label.Crear';
    case Update = 'label.Editar';
    case Delete = 'label.Eliminar';

    public static function map(): array
    {
        return [
            self::Create->value => [RoleEnum::Desarrollador, RoleEnum::JefeUnidad],
            self::Update->value => [RoleEnum::Desarrollador, RoleEnum::JefeUnidad],
            self::Delete->value => [RoleEnum::Desarrollador, RoleEnum::JefeUnidad],
        ];
    }
}
