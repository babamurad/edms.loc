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
        if(auth()->user()->hasRole('admin')){
            $documents = Document::paginate(5);
        } else {
            $documents = Document::where('user_id', auth()->user()->id)->paginate(5);
        } 
        dd($documents);                                                  
        return view('livewire.documents.documents-index', compact('documents'));
    }
}
