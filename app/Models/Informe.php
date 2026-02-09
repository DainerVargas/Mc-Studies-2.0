<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informe extends Model
{
    use HasFactory;

    protected $fillable = [
        'apprentice_id',
        'abono',
        'metodo',
        'fecha',
        'fechaRegistro',
        'urlImage',
    ];

    public function apprentice()
    {
        return $this->belongsTo(Apprentice::class);
    }
}
