<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    protected $fillable = [
        'name',
        'type_account',
        'number',
        'teacher_id',
    ];
}
