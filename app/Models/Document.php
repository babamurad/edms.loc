<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\DocumentShare;

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

    public function getReceivedFileUrlAttribute()
    {
        // Получаем отправителя из связанной записи DocumentShare
        $documentShare = $this->documentShares()->where('document_id', $this->id)->first();
        if (!$documentShare) {
            return null;
        }

        $sender = User::find($documentShare->sender_id);
        if (!$sender) {
            return null;
        }

        return 'storage/public/documents/' . $sender->name . '/' . $this->file;
    }

    // Добавьте отношение к DocumentShare
    public function documentShares()
    {
        return $this->hasMany(DocumentShare::class);
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

    /**
     * Связь с пользователем (автором документа)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Альтернативное название для связи с пользователем
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Связь с категорией
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Связь с отделом
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Связь с папкой
     */
    public function folder()
    {
        return $this->belongsTo(Folder::class, 'folder');
    }
}
