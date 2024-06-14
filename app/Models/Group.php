<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'teacher_id',
        'type_id',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function apprentice()
    {
        return $this->hasMany(Apprentice::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
