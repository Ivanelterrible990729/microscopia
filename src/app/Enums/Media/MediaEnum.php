<?php

namespace App\Enums\Media;

use App\Concerns\Enums\EnumToArray;

/**
 * Enum de los diferentes tipos de archivo (colecciones) en el sistema.
 */
enum MediaEnum: string
{
    use EnumToArray;

    case Images = 'Images';
    case CNN_MODEL = 'CNN Model';
}
