<?php

namespace App\Enums;

use App\Concerns\Enums\EnumToArray;

/**
 * Enumerado para mostrar las modalidades del App\Models\PlanDocencia.
 *
 * @enum
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
