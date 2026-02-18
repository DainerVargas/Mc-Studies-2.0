<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignedActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'archivo',
        'user_id'
    ];

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'assigned_activity_group');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
