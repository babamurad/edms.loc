<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentShare extends Model
{
    protected $fillable = [
        'document_id',
        'sender_id',
        'recipient_id',
        'status_id',
        'message',
        'read_at'
    ];

    protected $dates = [
        'read_at'
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
