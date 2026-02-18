<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterHours extends Model
{
    protected $fillable = [
        'teacher_id',
        'horas',
        'lunes',
        'martes',
        'miercoles',
        'jueves',
        'viernes',
        'sabado',
        'pago',
        'metodo',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
