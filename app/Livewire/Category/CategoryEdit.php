<?php

namespace App\Livewire\Category;

use App\Models\Category;
use App\Models\Department;
use Illuminate\Support\Str;
use Livewire\Component;

class CategoryEdit extends Component
{
    public $title, $slug, $description;
    public $editId;
    public $departmentId;

    protected $rules = [
        'title' => 'required|max:255',
        'slug' => 'required'
    ];

    public function render()
    {
        $departments = Department::all();
        return view('livewire.category.category-edit', compact('departments'));
    }

    public function mount($id)
    {
        $this->editId = $id;
        $category = Category::findOrFail($this->editId);
        $this->title = $category->title;
        $this->slug = $category->slug;
        $this->departmentId = $category->department_id;
        $this->description = $category->description;
    }

    public function update()
    {
        $this->validate();
        $category = Category::findOrFail($this->editId);
        $category->title = $this->title;
        $category->slug = $this->slug;
        $category->department_id = $this->departmentId;
        $category->description = $this->description;
        $category->save();
        session()->flash('success', 'Category updated successfully.');
        redirect()->route('category');
    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->title);
    }
}
