<?php

namespace App\Livewire;

use App\Models\Department;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Livewire\Component;

class HomeComponent extends Component
{
    public $departments;
    public $categories;
    public $documents;
    public $users;

    public function mount()
    {
        // Получаем количество записей для каждой модели
        $this->departments = Department::count();
        $this->categories = Category::count();
        
        // Для документов можно добавить условие для обычных пользователей
        if (auth()->user()->hasRole('admin')) {
            $this->documents = Document::count();
        } else {
            $this->documents = Document::where('user_id', auth()->id())->count();
        }
        
        $this->users = User::where('active', true)->count();
    }

    public function render()
    {
        return view('livewire.home-component');
    }
}
