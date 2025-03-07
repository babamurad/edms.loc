<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class ProfileComponent extends Component
{
    public $isEdit = false;
    public $name, $email, $password;

    protected function rules()
    {
        return [
            'name' => 'required|min:3|max:50|string',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'password' => 'nullable|min:6',
        ];
    }

    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->email = auth()->user()->email;
    }

    public function save()
    {
        $this->validate($this->rules());

        $user = User::findOrFail(auth()->id());
        $user->name = $this->name;
        $user->email = $this->email;
        if ($this->password) {
            $user->password = bcrypt($this->password);
        }
        $user->save();
        $this->isEdit = false;

        session()->flash('success', 'Profile updated successfully.');
    }

    public function render()
    {
        return view('livewire.profile-component');
    }
}
