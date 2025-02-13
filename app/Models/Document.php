<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'category_id', 'department_id', 'user_id', 'file', 'type', 'is_published', 'status_id', 'content', 'approved_at', 'rejected_at', 'submitted_at', 'published_at', 'archived_at'
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * Получить URL файла
     */
    public function getFileUrlAttribute()
    {
        return 'storage/public/documents/' . auth()->user()->name . '/' . $this->file;
    }

    /**
     * Получить расширение файла
     */
    public function getFileExtensionAttribute()
    {
        return pathinfo($this->file, PATHINFO_EXTENSION);
    }

    /**
     * Получить CSS-класс иконки в зависимости от типа файла
     */
    public function getFileIconAttribute()
    {
        return match (strtolower($this->file_extension)) {
            'pdf' => 'bi-file-earmark-pdf',
            'doc', 'docx' => 'bi-file-earmark-word',
            'xls', 'xlsx' => 'bi-file-earmark-excel',
            'jpg', 'jpeg', 'png', 'gif' => 'bi-file-earmark-image',
            'zip', 'rar' => 'bi-file-earmark-zip',
            'mp4', 'avi' => 'bi-file-earmark-play',
            default => 'bi-file-earmark',
        };
    }
}
