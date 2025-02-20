<?php

namespace App\Enums\Media;

use App\Concerns\Enums\EnumToArray;

/**
 * Enum de los diferentes tipos de archivo (colecciones) en el sistema.
 */
enum MediaEnum: string
{
    use EnumToArray;

    case Images = 'no_label'; // No cambiar, se utiliza así para el almacenamiento de imagenes.
    case CNN_Model = 'cnn_model';
}
