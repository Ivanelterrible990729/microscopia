<?php

namespace App\Enums\Permissions;

use App\Concerns\Enums\HasPermissions;
use App\Enums\RoleEnum;

enum ImagePermission: string
{
    use HasPermissions;

    case ViewAny = 'image.Ver cualquiera';
    case View = 'image.Ver';
    case Upload = 'image.Subir';
    case Update = 'image.Editar';
    case Delete = 'image.Eliminar';

    public static function map(): array
    {
        return [
            self::ViewAny->value => [RoleEnum::Desarrollador, RoleEnum::Directivo, RoleEnum::JefeUnidad, RoleEnum::TecnicoUnidad],
            self::View->value => [RoleEnum::Desarrollador, RoleEnum::Directivo, RoleEnum::JefeUnidad, RoleEnum::TecnicoUnidad],
            self::Upload->value => [RoleEnum::Desarrollador, RoleEnum::JefeUnidad, RoleEnum::TecnicoUnidad],
            self::Update->value => [RoleEnum::Desarrollador, RoleEnum::JefeUnidad, RoleEnum::TecnicoUnidad],
            self::Delete->value => [RoleEnum::Desarrollador, RoleEnum::JefeUnidad, RoleEnum::TecnicoUnidad],
        ];
    }
}
