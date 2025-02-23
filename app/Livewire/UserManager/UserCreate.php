<?php

namespace App\Livewire\UserManager;

use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserCreate extends Component
{
    public $name;
    public $email;
    public $password;
    public $department_id;
    public $selectedRoles = [];
    
    protected $rules = [
        'name' => 'required|min:3|max:50|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8',
        'department_id' => 'nullable|exists:departments,id',
        'selectedRoles' => 'array'
    ];

    public function render()
    {
        return view('livewire.user-manager.user-create', [
            'departments' => Department::all(),
            'roles' => Role::all()
        ]);
    }

    public function save()
    {
        $this->validate();

        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = Hash::make($this->password);
        $user->department_id = $this->department_id;
        $user->active = true;
        $user->save();

        // Назначаем выбранные роли
        if (!empty($this->selectedRoles)) {
            $user->roles()->attach($this->selectedRoles);
        }

        session()->flash('success', 'User created successfully.');
        return redirect()->route('user-manager');
    }
}
