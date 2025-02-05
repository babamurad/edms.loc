<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Login extends Component
{
    public $email, $password;

    protected $rules = [
        'email' => ['required', 'email'],
        'password' => ['required'],
    ];

    #[Layout('layouts.user-app')]
    public function render()
    {
        return view('livewire.user.login');
    }

    public function login()
    {
        $this->validate();
        
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();
            session()->flash('success', 'Вы успешно вошли в систему');
            return redirect()->route('home');
        }
        
        session()->flash('error', 'Неверный email или пароль');
        return null;

        
        // return back()->withErrors([
        //     'email' => 'The provided credentials do not match our records.',
        // ])->onlyInput('email');
    }
}
