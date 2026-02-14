<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reunion extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendant_id',
        'titulo',
        'descripcion',
        'fecha_programada',
        'estado',
        'respuesta_admin',
        'link_reunion',
    ];

    protected $casts = [
        'fecha_programada' => 'datetime',
    ];

    public function attendant()
    {
        return $this->belongsTo(Attendant::class);
    }
}
