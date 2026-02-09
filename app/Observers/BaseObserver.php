<?php

namespace App\Observers;

use App\Services\ActivityLogService;
use Illuminate\Database\Eloquent\Model;

abstract class BaseObserver
{
    /**
     * Get the descriptive name of the entity.
     */
    abstract protected function getEntityName(): string;

    /**
     * Handle the Model "created" event.
     */
    public function created(Model $model): void
    {
        $entityName = $this->getEntityName();
        $name = $model->name ?? $model->id;

        ActivityLogService::log(
            'created',
            $entityName,
            "Se ha creado un nuevo {$entityName}: {$name}",
            $model->id,
            null,
            $model->toArray()
        );
    }

    /**
     * Handle the Model "updated" event.
     */
    public function updated(Model $model): void
    {
        $entityName = $this->getEntityName();
        $name = $model->name ?? $model->id;

        // Get only dirty attributes
        $newValues = $model->getChanges();
        $oldValues = array_intersect_key($model->getOriginal(), $newValues);

        // If no changes were actually made (only updated_at or nothing relevant), skip
        if (empty($newValues) || (count($newValues) === 1 && isset($newValues['updated_at']))) {
            return;
        }

        ActivityLogService::log(
            'updated',
            $entityName,
            "Se ha actualizado el {$entityName}: {$name}",
            $model->id,
            $oldValues,
            $newValues
        );
    }

    /**
     * Handle the Model "deleted" event.
     */
    public function deleted(Model $model): void
    {
        $entityName = $this->getEntityName();
        $name = $model->name ?? $model->id;

        ActivityLogService::log(
            'deleted',
            $entityName,
            "Se ha eliminado el {$entityName}: {$name}",
            $model->id,
            $model->toArray(),
            null
        );
    }
}
