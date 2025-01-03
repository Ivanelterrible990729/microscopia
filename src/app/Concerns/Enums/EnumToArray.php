<?php

namespace App\Concerns\Enums;

use Illuminate\Support\Collection;

trait EnumToArray
{
    /**
     *  Devuelve un array ['name'] para los nombres a mostrar del enumerado.
     *
     * @return array<string>
     */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     *  Devuelve un array ['value'] para los valores del enumerado.
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     *  Devuelve un array ['value' => 'name'] del enumerado.
     *
     * @return array<string>
     */
    public static function array(): array
    {
        return array_combine(self::values(), self::names());
    }

    /**
     * Retorna el primer elemento de los valores del enum.
     *
     * @return string
     */
    public static function indexValue($index = 0): string
    {
        return self::values()[$index];
    }
}
