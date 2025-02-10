<?php

namespace App\Livewire\Documents;

use App\Models\Document;
use Livewire\Component;

class DocumentsIndex extends Component
{
    public $title, $slug, $description;
    public $delId;

    protected $rules = [
        'title' => 'required|max:255',
        'slug' => 'required'
    ];

    public function render()
    {
        $documents = Document::paginate(5);
        return view('livewire.documents.documents-index', compact('documents'));
    }
}
