<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class typeService extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function service()
    {
        return $this->hasMany(Service::class);
    }
}
