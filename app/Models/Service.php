<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'fecha',
        'valor',
        'combrobante',
        'type_service_id',
    ];

    public function typeService()
    {
        return $this->belongsTo(typeService::class);
    }
}
