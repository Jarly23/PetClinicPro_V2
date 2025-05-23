<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserCreate extends Component
{
    public $name, $email, $telefono, $password, $role;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'telefono' => 'required|string|max:11',
        'password' => 'required|string|min:8',
        'role' => 'required|in:Admin,veterinario'

    ];

    public function mount(){
        //Verificar si el usuario autenticado es administrador
        if(!auth()->user()->hasRole('Admin')){
            abort(403,'No tienes permiso para crear usuarios.');
        }
    }
    public function save(){
        $this->validate();
        $user = User::create([
            'name' =>$this->name,
            'email'=> $this->email,
            'password'=> Hash::make($this->password),
        ]);

        //Asignar rol a usuario;
        $user->assignRole($this->role);

        session()->flash('message', 'Usuario creado exitosamente.');
        return redirect()->route('admin.users-index');
    }
    public function render()
    {
        return view('livewire.user-create',[
            'roles' => Role::pluck('name', 'name')->toArray(),
        ]);
    }
}
