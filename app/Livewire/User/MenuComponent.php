<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class MenuComponent extends Component
{
    #[On('change-profile-image')]
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
