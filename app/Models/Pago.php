<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = [
        'apprentice_id',
        'monto',
        'metodo_pago_id',
        'dinero', // 'ingreso' o 'egreso'
        'created_at',
    ];
    public function apprentice()
    {
        return $this->belongsTo(Apprentice::class);
    }

    public function metodo()
    {
        return $this->belongsTo(MetodoPago::class, 'metodo_pago_id');
    }
}
