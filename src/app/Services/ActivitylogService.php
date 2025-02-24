<?php

namespace App\Services;

use App\Contracts\Services\ActivityInterface;
use Illuminate\Database\Eloquent\Model;

class ActivitylogService implements ActivityInterface
{
    /**
     * Propiedad para guardar cambios entre propiedades de un mismo modelo.
     */
    protected null|array $oldProperties = null;

    /**
     * Asigna propiedades viejas. (Para registros de actualización)
     */
    public function setOldProperties(array $properties): void
    {
        $this->oldProperties = $properties;
    }

    /**
     * Realiza log.
     */
    public function logActivity(string $logName, null|Model $performedOn, array $properties, string $description, bool $causedByAnonymous = false): void
    {
        $activity = activity($logName);

        if (isset($performedOn)) {
            $activity = $activity->performedOn($performedOn);
        }

        $logProperties = isset($this->oldProperties)
            ? [
                'attributes' => $properties,
                'old' => $this->oldProperties,
            ]
            : [
                'attributes' => $properties,
            ];

        $activity = $activity->withProperties($logProperties);

        if ($causedByAnonymous) {
            $activity = $activity->causedByAnonymous();
        }

        $activity = $activity->log($description);
        $this->oldProperties = null;
    }
}
