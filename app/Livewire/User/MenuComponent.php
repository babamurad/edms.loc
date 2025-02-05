<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MenuComponent extends Component
{
    public function render()
    {
        return view('livewire.user.menu-component');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
