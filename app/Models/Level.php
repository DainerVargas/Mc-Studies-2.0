<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    public function apprentice()
    {
        return $this->hasMany(Apprentice::class);
    }
}
