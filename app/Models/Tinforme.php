<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tinforme extends Model
{
    use HasFactory;

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function apprentice()
    {
        return $this->belongsTo(Apprentice::class);
    }

    protected $fillable = [
        'teacher_id',
        'abono',
        'fecha'
    ];
}
