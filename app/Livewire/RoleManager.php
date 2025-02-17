<?php

namespace App\Livewire;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class RoleManager extends Component
{
    public $roles;
    public $selectedUser = null;
    public $selectedRole = null;
    public $userOptions = [];

    public function mount()
    {
        $this->roles = Role::all();
        $this->userOptions = $this->getUsersForSelect();
    }

    public function getUsersForSelect()
    {
        return User::all()->map(function($user) {
            return [
                'value' => $user->id,
                'label' => $user->name
            ];
        });
    }

    public function updateSelectedUser($value)
    {
        $this->selectedUser = $value;
    }

    public function assignRole()
    {
        if (!$this->selectedUser || !$this->selectedRole) {
            session()->flash('error', 'Выберите пользователя и роль');
            return;
        }

        $user = User::find($this->selectedUser);
        if (!$user) {
            session()->flash('error', 'Пользователь не найден');
            return;
        }

        $user->roles()->syncWithoutDetaching([$this->selectedRole]);
        session()->flash('success', 'Роль успешно назначена');
    }

    public function render()
    {
        return view('livewire.role-manager');
    }

    protected function getListeners()
    {
        return [
            'custom-select-updated' => 'updateSelectedUser'
        ];
    }
}
