<?php

namespace App\Livewire\Department;

use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;

class DepartmentIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $delId;
    public $perPage = 8;
    public $showModal = false;

    public function render()
    {
        $departments = Department::paginate($this->perPage);
        return view('livewire.department.department-index', compact('departments'));
    }

    public function delete($id)
    {
        $this->delId = $id;
    }

    public function destroy()
    {
        $department = Department::findOrFail($this->delId);
        $department->delete();
        $this->showModal = false;
        session()->flash('success', 'Department deleted successfully.');
    }
}
