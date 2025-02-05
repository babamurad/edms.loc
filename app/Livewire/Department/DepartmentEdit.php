<?php

namespace App\Livewire\Department;

use App\Models\Department;
use Illuminate\Support\Str;
use Livewire\Component;

class DepartmentEdit extends Component
{
    public $title, $slug, $description;
    public $editId;

    protected $rules = [
        'title' => 'required|max:255',
        'slug' => 'required'
    ];

    public function render()
    {
        return view('livewire.department.department-edit');
    }

    public function mount($id)
    {
        $this->editId = $id;
        $department = Department::findOrFail($this->editId);
        $this->title = $department->title;
        $this->slug = $department->slug;
        $this->description = $department->description;
    }

    public function update()
    {
        $this->validate();
        $department = Department::findOrFail($this->editId);
        $department->title = $this->title;
        $department->slug = $this->slug;
        $department->description = $this->description;
        $department->save();
        session()->flash('success', 'Department updated successfully.');
        redirect()->route('department');
    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->title);
    }
}
