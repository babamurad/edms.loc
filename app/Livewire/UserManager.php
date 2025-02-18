<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class UserManager extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 8;

    public function render()
    {
        $users = User::where('active', true)->with('department')->paginate($this->perPage);
        return view('livewire.user-manager');
    }
}
