<?php

namespace App\Livewire\Category;

use App\Models\Category;
use App\Models\Department;
use Illuminate\Support\Str;
use Livewire\Component;

class CategoryCreate extends Component
{
    public $title, $slug, $description;
    public $departmentId;
    protected $rules = [
        'title' => 'required|max:255',
        'slug' => 'required'
    ];

    public function render()
    {
        $departments = Department::all();
        return view('livewire.category.category-create', compact('departments'));
    }

    public function create()
    {
        $this->validate();
        $category = new Category();
        $category->title = $this->title;
        $category->slug = $this->slug;
        $category->department_id = $this->departmentId;
        $category->description = $this->description;
        $category->save();
        session()->flash('success', 'Category created successfully.');
        return redirect()->route('category');
    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->title);
    }
}
