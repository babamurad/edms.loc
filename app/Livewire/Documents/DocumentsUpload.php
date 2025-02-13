<?php

namespace App\Livewire\Documents;

use App\Models\Category;
use App\Models\Department;
use App\Models\Document;
use App\Models\Status;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class DocumentsUpload extends Component
{
    use WithFileUploads;
    public $contentDocs;
    public $titleDocs;
    public $fileDocs;

    public $title, $slug, $description;
    public $departments;
    public $categories;
    public $statuses;
    public $selectedStatus;
    public $selectedDepartment;
    public $selectedCategory;
    public $user_id, $file, $type, $is_published, $status_id, $comment, $approved_at, $rejected_at, $submitted_at, $published_at, $archived_at;

    protected $rules = [
        'title' =>'required|min:5',
//        'description' =>'required|min:10',
        'file' =>'required|mimes:pdf,docx,xlsx,jpg,jpeg|max:20480',
//        'is_published' => 'required|default:0'
    ];

    public function render()
    {
        return view('livewire.documents.documents-upload');
    }

    public function mount()
    {
        $this->departments = Department::all();
        $this->categories = Category::all();
        $this->statuses = Status::all();
    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->title);
    }

    public function saveDocument()
    {
        //
        $this->validate();
//        dd('suibmite');
        $document = new Document();
        $document->title = $this->title;
        $document->slug = $this->slug;
        $document->description = $this->description;
        $document->user_id = auth()->id();
        $document->department_id = $this->selectedDepartment;
        $document->category_id = $this->selectedCategory;
        $document->status_id = $this->selectedStatus;
        $document->is_published = $this->is_published?? 0;
        $filename = time() . '_' . $this->file->getClientOriginalName();
        $this->file->storeAs('public/documents/' . auth()->user()->name, $filename);
        $document->file = $filename;
        $document->save();

        // Upload file


        $this->reset();
        session()->flash('message', 'Document uploaded successfully!');
        // Redirect to the uploaded document page
        return redirect()->route('documents');

    }
}
