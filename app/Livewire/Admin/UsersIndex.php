<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;

class UsersIndex extends Component
{
    public function render()
    {
        $users = User::all();
        return view('livewire.admin.users-index',compact('users'));
    }
}
