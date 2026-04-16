<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['name', 'document_category_id', 'file_path'];

    public function documentCategory()
    {
        return $this->belongsTo(DocumentCategory::class);
    }
}
