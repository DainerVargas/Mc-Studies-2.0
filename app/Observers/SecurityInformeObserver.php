<?php

namespace App\Observers;

use App\Models\SecurityInforme;
use App\Services\ActivityLogService;
use Illuminate\Database\Eloquent\Model;

class SecurityInformeObserver extends BaseObserver
{
    protected function getEntityName(): string
    {
        return 'Copia de Seguridad';
    }

    /**
     * Handle the SecurityInforme "created" event.
     */
    public function created(Model $model): void
    {
        ActivityLogService::log(
            'backup',
            'Informe',
            "Se ha creado una copia de seguridad para el estudiante: {$model->estudiante}",
            $model->id,
            null,
            $model->toArray()
        );
    }
}
