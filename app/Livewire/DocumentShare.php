<?php

namespace App\Livewire;

use App\Models\Document;
use App\Models\DocumentShare as DocumentShareModel;
use App\Models\User;
use App\Models\Department;
use Livewire\Component;

class DocumentShare extends Component
{
    public $document;
    public $selectedUsers = [];
    public $message;
    public $showModal = false;

    public function mount(Document $document)
    {
        $this->document = $document;
    }

    public function render()
    {
        $departments = Department::with(['users' => function($query) {
            $query->where('active', true)
                  ->where('id', '!=', auth()->id());
        }])->get();
        return view('livewire.document-share', [
            'departments' => $departments
        ]);
    }

    public function shareDocument()
    {
        $this->validate([
            'selectedUsers' => 'required|array|min:1',
            'message' => 'nullable|string'
        ]);

        foreach ($this->selectedUsers as $userId) {
            DocumentShareModel::create([
                'document_id' => $this->document->id,
                'sender_id' => auth()->id(),
                'recipient_id' => $userId,
                'status_id' => 1,
                'message' => $this->message
            ]);
        }

        $this->reset(['selectedUsers', 'message']);
        $this->showModal = false;
        session()->flash('success', 'Document shared successfully');
    }
}
