<?php

namespace App\Livewire\Department;

use App\Models\Department;
use Livewire\Component;

class DepartmentCreate extends Component
{
    public $title, $slug, $description;
    protected $rules = [
        'title' => 'required|max:255'
    ];

    public function render()
    {
        return view('livewire.department.department-create');
    }

    public function create()
    {
        $department = new Department();
        $department->title = $this->title;
        $department->slug = $this->slug;
        $department->description = $this->description;
        $department->save();

        redirect()->route('department');

        session()->flash('success', 'Department created successfully.');
    }
}
