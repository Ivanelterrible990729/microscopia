<?php

namespace App\Contracts\Services;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;

interface ActivityInterface
{
    /**
     * Asigna propiedades viejas. (Para registros de actualización)
     */
    public function setOldProperties(array $properties): void;

    /**
     * Realiza log.
     */
    public function logActivity(string $logName, null|Model $performedOn, array $properties, string $description, bool $causedByAnonymous = false): void;
}
