<?php

namespace App\Repositories;

use App\Models\Label;

class LabelRepository
{
    /**
     * Crea un registro label en la base de datos
     */
    public function create(array $data): Label
    {
        return Label::create($data);
    }

    /**
     * Actualiza un registro label en la base de datos
     */
    public function update(Label $label, array $data): Label
    {
        $label->update($data);
        return $label;
    }

    /**
     * Elimina un registro label en la base de datos
     */
    public function delete(Label $label): void
    {
        $label->delete();
    }
}
