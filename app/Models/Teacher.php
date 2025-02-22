<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    public function group()
    {
        return $this->hasMany(Group::class);
    }
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    public function type_teacher()
    {
        return $this->belongsTo(TypeTeacher::class);
    }

    public function tinforme()
    {
        return $this->hasMany(Tinforme::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }

    protected $fillable = [
        'name',
        'email',
        'image',
        'estado',
        'telefono',
        'apellido',
        'type_teacher_id',
        'fecha_inicio',
        'fecha_fin',
    ];

    public function image()
    {
        return asset('users/' . $this->imageName);
    }
}
