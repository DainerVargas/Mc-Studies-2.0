<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendant_id',
        'apprentice_id',
        'titulo',
        'descripcion',
        'archivo',
        'fecha',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function attendant()
    {
        return $this->belongsTo(Attendant::class);
    }

    public function apprentice()
    {
        return $this->belongsTo(Apprentice::class);
    }
}
