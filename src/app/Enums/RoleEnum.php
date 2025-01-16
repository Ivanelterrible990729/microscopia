<?php

namespace App\Enums;

use App\Concerns\Enums\EnumToArray;

/**
 * Enum de roles en el sistema.
 */
enum RoleEnum: string
{
    use EnumToArray;

    case Desarrollador = 'Desarrollador';
    case Administrador = 'Administrador';
    case Directivo = 'Directivo';
    case JefeUnidad = 'Jefe de unidad';
    case TecnicoUnidad = 'Técnico de unidad';
}
