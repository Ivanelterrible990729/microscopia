<?php

namespace App\Enums\CnnModel;

use App\Concerns\Enums\EnumToArray;

/**
 * Enum de roles en el sistema.
 */
enum AvailableModelsEnum: string
{
    use EnumToArray;

    case MobileNetV2 = 'MobileNetV2';
    case VGG16 = 'VGG16';
    case AlexNet = 'AlexNet';
}
