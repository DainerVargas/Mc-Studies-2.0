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

    public function qualification()
    {
        return $this->hasMany(Qualification::class);
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

    public function RegisterHours()
    {
        return $this->hasMany(RegisterHours::class);
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
        'precio_hora',
    ];

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function image()
    {
        return asset('users/' . $this->imageName);
    }

    public function qualifications()
    {
        return $this->hasMany(Qualification::class);
    }
}
