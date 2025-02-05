<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Register extends Component
{
    public $name, $email, $password, $accept;

    protected $rules = [
        'name' => 'required|min:3|max:50|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8',
        'accept' => 'required|boolean'
    ];

    #[Layout('layouts.user-app')]
    public function render()
    {
        return view('livewire.user.register');
    }

    public function save()
    {
        $this->validate();

        // Отладочное сообщение
        session()->flash('message', 'Валидация прошла успешно!');

        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = bcrypt($this->password);
        $user->save();
        Auth::login($user);

        return redirect()->route('home');
    }
}
