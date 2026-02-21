<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    protected $fillable = [
        'apprentice_id',
        'teacher_id',
        'group_id',
        'speaking',
        'reading',
        'writing',
        'listening',
        'worksheet_entregados',
        'worksheet_asignados',
        'actividades_entregados',
        'actividades_asignados',
        'semestre',
        'resultado',
        'observacion',
        'year',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function apprentice()
    {
        return $this->belongsTo(Apprentice::class, 'apprentice_id');
    }
}
