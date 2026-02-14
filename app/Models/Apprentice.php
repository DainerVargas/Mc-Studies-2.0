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
    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }
    public function informe()
    {
        return $this->hasMany(Informe::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    public function qualification()
    {
        return $this->hasMany(Qualification::class);
    }

    public function becado()
    {
        return $this->belongsTo(Becado::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }

    public function activities()
    {
        return $this->hasMany(AcademicActivity::class);
    }

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    protected $fillable = [
        'name',
        'apellido',
        'edad',
        'email',
        'documento',
        'telefono',
        'fecha_nacimiento',
        'estado',
        'becado_id',
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
        'level_id',
        'sede_id',
    ];
}
