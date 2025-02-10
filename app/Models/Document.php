<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'category_id', 'department_id', 'user_id', 'file', 'type', 'is_published', 'status_id', 'comment', 'approved_at', 'rejected_at', 'submitted_at', 'published_at', 'archived_at'
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
