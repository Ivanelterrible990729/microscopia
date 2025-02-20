<?php

namespace App\Enums\Permissions;

use App\Concerns\Enums\HasPermissions;
use App\Enums\RoleEnum;

enum CnnModelPermission: string
{
    use HasPermissions;

    case ViewAny = 'cnn-model.Ver cualquiera';
    case View = 'cnn-model.Ver';
    case Create = 'cnn-model.Crear';
    case Update = 'cnn-model.Editar';
    case Delete = 'cnn-model.Eliminar';

    public static function map(): array
    {
        return [
            self::ViewAny->value => [RoleEnum::Desarrollador, RoleEnum::Administrador],
            self::View->value => [RoleEnum::Desarrollador, RoleEnum::Administrador],
            self::Create->value => [RoleEnum::Desarrollador, RoleEnum::Administrador],
            self::Update->value => [RoleEnum::Desarrollador, RoleEnum::Administrador],
            self::Delete->value => [RoleEnum::Desarrollador, RoleEnum::Administrador],
        ];
    }
}
