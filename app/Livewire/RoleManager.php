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
    public $userRoles = [];

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
        $this->loadUserRoles();
    }

    public function loadUserRoles()
    {
        if ($this->selectedUser) {
            $user = User::find($this->selectedUser);
            if ($user) {
                $this->userRoles = $user->roles()->get();
            }
        } else {
            $this->userRoles = [];
        }
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

        // Проверяем, есть ли уже такая роль у пользователя
        if ($user->roles()->where('role_id', $this->selectedRole)->exists()) {
            session()->flash('error', 'Эта роль уже назначена пользователю');
            return;
        }

        $user->roles()->syncWithoutDetaching([$this->selectedRole]);
        $this->loadUserRoles();
        $this->selectedRole = null;
        session()->flash('success', 'Роль успешно назначена');
    }

    public function removeRole($roleId)
    {
        if (!$this->selectedUser) {
            session()->flash('error', 'Пользователь не выбран');
            return;
        }

        $user = User::find($this->selectedUser);
        if (!$user) {
            session()->flash('error', 'Пользователь не найден');
            return;
        }

        $user->roles()->detach($roleId);
        $this->loadUserRoles();
        session()->flash('success', 'Роль успешно удалена');
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
