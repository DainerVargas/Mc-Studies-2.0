<?php

namespace App\Observers;

use App\Models\Apprentice;

class ApprenticeObserver extends BaseObserver
{
    protected function getEntityName(): string
    {
        return 'Estudiante';
    }

    /**
     * Handle the Apprentice "updated" event.
     */
    public function updated(\Illuminate\Database\Eloquent\Model $model): void
    {
        if ($model->wasChanged('descuento')) {
            \App\Services\ActivityLogService::log(
                'updated',
                'Descuento',
                "Se ha aplicado un descuento de \${$model->descuento} al estudiante: {$model->name} {$model->apellido}",
                $model->id,
                ['descuento' => $model->getOriginal('descuento')],
                ['descuento' => $model->descuento]
            );
        } else {
            parent::updated($model);
        }
    }
}
