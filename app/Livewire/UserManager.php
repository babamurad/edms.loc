<?php

namespace App\Livewire;

use Livewire\Component;

class UserManager extends Component
{
    public function render()
    {
        $users = User::all();
        return view('livewire.user-manager');
    }
}
