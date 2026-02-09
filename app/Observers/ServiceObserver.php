<?php

namespace App\Observers;

use App\Models\Service;

class ServiceObserver extends BaseObserver
{
    protected function getEntityName(): string
    {
        return 'Servicio';
    }
}
