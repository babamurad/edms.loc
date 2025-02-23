<?php

namespace App\Livewire\UserManager;

use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UserEdit extends Component
{
    public $userId;
    public $name;
    public $email;
    public $password;
    public $department_id;
    public $selectedRoles = [];

    public function mount($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->department_id = $user->department_id;
        $this->selectedRoles = $user->roles->pluck('id')->toArray();
    }

    protected function rules()
    {
        return [
            'name' => 'required|min:3|max:50|string',
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->userId)],
            'password' => 'nullable|min:8',
            'department_id' => 'nullable|exists:departments,id',
            'selectedRoles' => 'array'
        ];
    }

    public function render()
    {
        return view('livewire.user-manager.user-edit', [
            'departments' => Department::all(),
            'roles' => Role::all()
        ]);
    }

    public function update()
    {
        $this->validate();

        $user = User::findOrFail($this->userId);
        $user->name = $this->name;
        $user->email = $this->email;
        if ($this->password) {
            $user->password = Hash::make($this->password);
        }
        $user->department_id = $this->department_id;
        $user->save();

        // Обновляем роли
        $user->roles()->sync($this->selectedRoles);

        session()->flash('success', 'User updated successfully.');
        return redirect()->route('user-manager');
    }
}
