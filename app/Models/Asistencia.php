<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    public $table = 'asistencias';

    protected $fillable = [
        'apprentice_id',
        'fecha',
        'observaciones',
        'teacher_id',
        'group_id',
        'estado',
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
