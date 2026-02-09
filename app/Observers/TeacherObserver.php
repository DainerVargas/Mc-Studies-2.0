<?php

namespace App\Observers;

use App\Models\Teacher;

class TeacherObserver extends BaseObserver
{
    protected function getEntityName(): string
    {
        return 'Profesor';
    }
}
