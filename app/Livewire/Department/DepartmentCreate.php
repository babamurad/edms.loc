<?php

namespace App\Livewire\Department;

use App\Models\Department;
use Livewire\Component;
use Illuminate\Support\Str;

class DepartmentCreate extends Component
{
    public $title, $slug, $description;
    protected $rules = [
        'title' => 'required|max:255',
        'slug' => 'required'
    ];

    public function render()
    {
        return view('livewire.department.department-create');
    }

    public function create()
    {
        $this->validate();
        $department = new Department();
        $department->title = $this->title;
        $department->slug = $this->slug;
        $department->description = $this->description;
        $department->save();

        redirect()->route('department');

        session()->flash('success', 'Department created successfully.');
    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->title);
    }

}
