<?php

namespace App\Livewire\Documents;

use App\Models\DocumentShare;
use Livewire\Component;
use Livewire\WithPagination;

class Outbox extends Component
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

    public function render()
    {
        $shares = DocumentShare::where('sender_id', auth()->id())
            ->with(['document', 'recipient', 'status'])
            ->when($this->search, function($query) {
                $query->whereHas('document', function($q) {
                    $q->where('title', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('recipient', function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->orWhere('message', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
            
        return view('livewire.documents.outbox', [
            'shares' => $shares
        ]);
    }
}
