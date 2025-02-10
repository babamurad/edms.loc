<?php

namespace App\Livewire\Documents;

use App\Models\Category;
use App\Models\Department;
use App\Models\Status;
use Illuminate\Support\Str;
use Livewire\Component;

class DocumentsCreate extends Component
{
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


    public function render()
    {
        return view('livewire.documents.documents-create');
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
}
