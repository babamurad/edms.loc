<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $delId;
    public $perPage = 5;
    public $showModal = false;

    public function render()
    {
        $categories = Category::with('department')->paginate($this->perPage);
        return view('livewire.category.category-index', compact('categories'));
    }

    public function delete($id)
    {
        $this->delId = $id;
    }

    public function destroy()
    {
        $category = Category::findOrFail($this->delId);
        $category->delete();
        $this->showModal = false;
        session()->flash('success', 'Category deleted successfully.');
    }
}
