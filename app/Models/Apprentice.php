<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apprentice extends Model
{
    use HasFactory;

    public function attendant()
    {
        return $this->belongsTo(Attendant::class, 'attendant_id'); 
    }

    public function modality()
    {
        return $this->belongsTo(Modality::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public function informe()
    {
        return $this->hasMany(Informe::class);
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    protected $fillable = [
        'name',
        'apellido',
        'edad',
        'email',
        'documento',
        'telefono',
        'fecha_nacimiento',
        'estado',
        'imagen',
        'modality_id',
        'plataforma',
        'fechaPlataforma',
        'attendant_id',
        'group_id',
        'valor',
        'descuento',
        'direccion',
        'observacion',
    ];
}
