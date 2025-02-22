<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendant extends Model
{
    use HasFactory;

    public function apprentice()
    {
        return $this->hasMany(Apprentice::class);
    }


    protected $fillable = [
        'name',
        'apellido',
        'email',
        'documento',
        'telefono',
    ];
}
