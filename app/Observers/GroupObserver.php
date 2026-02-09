<?php

namespace App\Observers;

use App\Models\Group;

class GroupObserver extends BaseObserver
{
    protected function getEntityName(): string
    {
        return 'Grupo';
    }
}
