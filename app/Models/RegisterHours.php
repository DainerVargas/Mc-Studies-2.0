<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterHours extends Model
{
    protected $fillable = ['teacher_id', 'fecha', 'horas'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
