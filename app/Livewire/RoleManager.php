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
    public $newRoleName;
    public $showCreateModal = false;
    public $userOptions = [];

    protected $rules = [
        'newRoleName' => 'required|min:3|unique:roles,name'
    ];

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

    public function createRole()
    {
        $this->validate();

        Role::create([
            'name' => $this->newRoleName
        ]);

        $this->newRoleName = '';
        $this->showCreateModal = false;
        $this->roles = Role::all();
        session()->flash('success', 'Роль успешно создана');
    }

    public function assignRole()
    {
        if (!$this->selectedUser || !$this->selectedRole) {
            session()->flash('error', 'Выберите пользователя и роль');
            return;
        }

        $user = User::find($this->selectedUser);
        $user->roles()->syncWithoutDetaching([$this->selectedRole]);
        session()->flash('success', 'Роль успешно назначена');
    }

    public function render()
    {
        return view('livewire.role-manager');
    }
}
