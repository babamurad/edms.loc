<?php

namespace App\Livewire\Documents;

use App\Models\DocumentShare;
use Livewire\Component;
use Livewire\WithPagination;

class DocumentInbox extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    
    public $search = '';
    public $perPage = 10;
    
    protected $queryString = ['search'];
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingPerPage()
    {
        $this->resetPage();
    }
    
    public function markAsRead($shareId)
    {
        $share = DocumentShare::findOrFail($shareId);
        
        if (!$share->read_at && $share->recipient_id == auth()->id()) {
            $share->read_at = now();
            $share->status_id = 2; // Прочитано
            $share->save();
        }
    }
    
    public function render()
    {
        $shares = DocumentShare::where('recipient_id', auth()->id())
            ->with(['document', 'sender', 'status'])
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->whereHas('document', function($subQ) {
                        $subQ->where('title', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('sender', function($subQ) {
                        $subQ->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%');
                    })
                    ->orWhere('message', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
            
        return view('livewire.documents.document-inbox', [
            'shares' => $shares
        ]);
    }
}
