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

    public function render()
    {
        $users = User::where('active', true)
            ->with(['department', 'roles'])
            ->paginate($this->perPage);
            
        return view('livewire.user-manager.user-manager', [
            'users' => $users
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
