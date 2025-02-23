<?php

namespace App\Livewire\Documents;

use App\Models\DocumentShare;
use Livewire\Component;
use Livewire\WithPagination;

class DocumentInbox extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $shares = DocumentShare::where('recipient_id', auth()->id())
            ->with(['document', 'sender', 'status'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('livewire.documents.document-inbox', [
            'shares' => $shares
        ]);
    }

    public function markAsRead($shareId)
    {
        $share = DocumentShare::find($shareId);
        if ($share && $share->recipient_id === auth()->id()) {
            $share->update([
                'read_at' => now(),
                'status_id' => 3 // ID статуса "Просмотрен"
            ]);
        }
    }
}