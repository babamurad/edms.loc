<?php

namespace App\Livewire\UserManager;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class UserManager extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    public $perPage = 8;
    public $delId;
    public $showModal = false;
    
    // Добавляем свойства для поиска и фильтрации
    public $search = '';
    public $selectedDepartment = '';
    
    // Отслеживаем изменения для сброса пагинации
    protected $queryString = ['search', 'selectedDepartment'];
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingSelectedDepartment()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::where('active', true)
            ->with(['department', 'roles'])
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedDepartment, function($query) {
                $query->where('department_id', $this->selectedDepartment);
            })
            ->paginate($this->perPage);
            
        $departments = \App\Models\Department::all();
            
        return view('livewire.user-manager.user-manager', [
            'users' => $users,
            'departments' => $departments
        ]);
    }

    public function destroy()
    {
        $user = User::findOrFail($this->delId);
        
        // Проверяем, не пытается ли пользователь удалить сам себя
        if ($user->id === auth()->id()) {
            session()->flash('error', 'You cannot delete your own account.');
            $this->showModal = false;
            return;
        }
        
        $user->active = false;
        $user->save();
        
        $this->showModal = false;
        session()->flash('success', 'User deleted successfully.');
    }
}
