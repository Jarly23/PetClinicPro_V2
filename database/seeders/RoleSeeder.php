<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Crear roles
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Recepcionista']);

        //Permisos Generales
        //permisos para usuarios
        Permission::create(['name' => 'users.index', 'description' => 'Ver la lista de usuarios'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.edit', 'description' => 'Editar usuarios'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.update', 'description' => 'Actualizar información de usuarios'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.destroy', 'description' => 'Eliminar usuarios'])->syncRoles($role1);

        //Permiso para roles
        Permission::create(['name' => 'roles.index', 'description' => 'Ver lista de Roles '])->syncRoles($role1);

        Permission::create(['name' => 'services.index', 'description' => 'Ver la lista de servicios'])->syncRoles([$role2]);
        Permission::create(['name' => 'services.create', 'description' => 'Crear servicios'])->syncRoles([$role2]);
        Permission::create(['name' => 'services.edit', 'description' => 'Editar servicios'])->syncRoles([$role2]);
        Permission::create(['name' => 'services.destroy', 'description' => 'Eliminar servicios'])->syncRoles([$role1, $role2]);
        
        Permission::create(['name' => 'veterinarians.index', 'description' => 'Ver la lista de veterinarios'])->syncRoles([$role2]);
        Permission::create(['name' => 'veterinarians.create', 'description' => 'Registrar veterinarios'])->syncRoles([$role2]);
        Permission::create(['name' => 'veterinarians.edit', 'description' => 'Editar veterinarios'])->syncRoles([$role2]);
        Permission::create(['name' => 'veterinarians.destroy', 'description' => 'Eliminar veterinarios'])->syncRoles([$role2]);
    }
}
