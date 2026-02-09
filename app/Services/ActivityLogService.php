<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogService
{
    /**
     * Log a system action.
     *
     * @param string $actionType Action performed (created, updated, deleted, etc.)
     * @param string $entityTitle Name of the entity (Student, Teacher, etc.)
     * @param string $description Human-readable description
     * @param mixed $entityId ID of the affected record
     * @param array|null $oldValues Previous values (optional)
     * @param array|null $newValues Current/New values (optional)
     */
    public static function log($actionType, $entityTitle, $description, $entityId = null, $oldValues = null, $newValues = null)
    {
        $user = Auth::user();

        ActivityLog::create([
            'user_id' => $user ? $user->id : null,
            'user_name' => $user ? $user->name : 'System',
            'user_role' => $user && $user->rol ? $user->rol->name : ($user ? 'User' : 'System'),
            'action_type' => $actionType,
            'entity_type' => $entityTitle,
            'entity_id' => $entityId,
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}
