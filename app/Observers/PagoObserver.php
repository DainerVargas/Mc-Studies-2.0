<?php

namespace App\Observers;

use App\Models\Pago;

class PagoObserver extends BaseObserver
{
    protected function getEntityName(): string
    {
        return 'Pagos';
    }

    protected function resolveEntityName(\App\Models\Pago $model): string
    {
        return $model->dinero === 'Ingresado' ? 'Pagos' : 'Caja';
    }

    public function created(\Illuminate\Database\Eloquent\Model $model): void
    {
        $monto = number_format($model->monto, 2);
        $entity = $this->resolveEntityName($model);

        if ($model->apprentice) {
            $sujeto = "el estudiante: " . $model->apprentice->name . " " . $model->apprentice->apellido;
        } else {
            $sujeto = "concepto: " . ($model->egresado ?? 'Sin concepto');
        }

        $tipo = $model->dinero === 'Ingresado' ? 'ingreso' : 'egreso';

        \App\Services\ActivityLogService::log(
            'created',
            $entity,
            "Se ha registrado un {$tipo} de \${$monto} para {$sujeto}",
            $model->id,
            null,
            $model->toArray()
        );
    }

    public function updated(\Illuminate\Database\Eloquent\Model $model): void
    {
        $monto = number_format($model->monto, 2);
        $entity = $this->resolveEntityName($model);

        if ($model->apprentice) {
            $sujeto = "el estudiante: " . $model->apprentice->name . " " . $model->apprentice->apellido;
        } else {
            $sujeto = "concepto: " . ($model->egresado ?? 'Sin concepto');
        }

        $newValues = $model->getChanges();
        $oldValues = array_intersect_key($model->getOriginal(), $newValues);

        \App\Services\ActivityLogService::log(
            'updated',
            $entity,
            "Se ha actualizado el registro de {$entity} de {$sujeto} (Monto actual: \${$monto})",
            $model->id,
            $oldValues,
            $newValues
        );
    }

    public function deleted(\Illuminate\Database\Eloquent\Model $model): void
    {
        $monto = number_format($model->monto, 2);
        $entity = $this->resolveEntityName($model);

        if ($model->apprentice) {
            $sujeto = "el estudiante: " . $model->apprentice->name . " " . $model->apprentice->apellido;
        } else {
            $sujeto = "concepto: " . ($model->egresado ?? 'Sin concepto');
        }

        \App\Services\ActivityLogService::log(
            'deleted',
            $entity,
            "Se ha eliminado un registro de {$entity} de \${$monto} relacionado con {$sujeto}",
            $model->id,
            $model->toArray(),
            null
        );
    }
}
