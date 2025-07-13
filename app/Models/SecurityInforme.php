<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityInforme extends Model
{
    protected $fillable = [
        'acudiente',
        'estudiante',
        'becado',
        'valor',
        'descuento',
        'abono',
        'pendiente',
        'plataforma',
        'fecha',
        'comprobante',
        'observacion',
    ];
}
