<?php

namespace App\Enums\CnnModel;

use App\Concerns\Enums\EnumToArray;

/**
 * Enum de roles en el sistema.
 */
enum AvailableModelsEnum: string
{
    use EnumToArray;

    case MobileNetV2 = 'cnn-models/base/mobilenetv2.keras';
    case VGG16 = 'cnn-models/base/vgg16.keras';

    /**
     *  Devuelve un array [r_esource_path('value') => 'name'] del enumerado.
     *
     * @return array<string>
     */
    public static function arrayResource(): array
    {
        return [
            resource_path(Self::MobileNetV2->value) =>Self::MobileNetV2->value,
            resource_path(Self::VGG16->value) =>Self::VGG16->value,
        ];
    }
}
