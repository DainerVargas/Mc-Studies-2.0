<?php

namespace App\Observers;

use App\Models\Informe;
use App\Services\ActivityLogService;
use Illuminate\Database\Eloquent\Model;

class InformeObserver extends BaseObserver
{
    protected function getEntityName(): string
    {
        return 'Abono/Informe';
    }

    /**
     * Handle the Informe "created" event.
     */
    public function created(Model $model): void
    {
        $monto = number_format($model->abono, 2);
        $estudiante = $model->apprentice ? $model->apprentice->name . ' ' . $model->apprentice->apellido : 'N/A';

        ActivityLogService::log(
            'payment',
            'Abono',
            "Se ha registrado un abono de \${$monto} para el estudiante: {$estudiante}",
            $model->id,
            null,
            $model->toArray()
        );
    }

    /**
     * Handle the Informe "updated" event.
     */
    public function updated(Model $model): void
    {
        // Only log if the abono or relevant fields changed
        if ($model->wasChanged('abono') || $model->wasChanged('metodo') || $model->wasChanged('fecha')) {
            $monto = number_format($model->abono, 2);
            $estudiante = $model->apprentice ? $model->apprentice->name . ' ' . $model->apprentice->apellido : 'N/A';

            $newValues = $model->getChanges();
            $oldValues = array_intersect_key($model->getOriginal(), $newValues);

            ActivityLogService::log(
                'updated',
                'Abono',
                "Se ha actualizado el abono de {$estudiante} a \${$monto}",
                $model->id,
                $oldValues,
                $newValues
            );
        }
    }
}
