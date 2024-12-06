<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Livewire\Features\SupportFormObjects\Form;


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
        $user->roles()->sync($request->roles);
        return redirect()->route('admin.users.edit',$user)->with('info','se asignó los roles asignados correctamente');
    }

 
    public function destroy(string $id)
    {
        //
    }
}
