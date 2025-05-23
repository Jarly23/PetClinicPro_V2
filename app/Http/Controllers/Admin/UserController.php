<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Livewire\Features\SupportFormObjects\Form;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
 
    public function index()
    {
        
        return view('admin.users.index');
    }

 
    public function create()
    {
    
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }
    public function edit(User $user )
    {
        //
        $roles = Role::all();

        return view('admin.users.edit',compact('user','roles'));
    }

  
    public function update(Request $request, User $user)
    {
        //
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
    
        'password' => 'nullable|string|min:8',
        'roles' => 'array',
    ]);

    // Actualizar datos básicos
    $user->name = $request->name;
    $user->email = $request->email;
   

    // Actualizar contraseña solo si se proporciona
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    // Sincronizar roles
    $user->roles()->sync($request->roles);

    // Redireccionar con mensaje
    return redirect()->route('admin.users.index', $user)
        ->with('info', 'El usuario fue actualizado correctamente.');    }

 
    public function destroy(string $id)
    {
        //
    }
}
