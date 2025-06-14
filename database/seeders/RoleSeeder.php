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
        $role1 = Role::firstOrCreate(['name' => 'Admin']);
        $role2 = Role::firstOrCreate(['name' => 'Veterinario']);
        $role3 = Role::firstOrCreate(['name' => 'Recepcionista']);

        //Permisos Generales
        //permisos para usuarios
        Permission::firstOrCreate(['name' => 'users.index', 'description' => 'Ver la lista de usuarios'])->syncRoles([$role1]);
        Permission::firstOrCreate(['name' => 'users.edit', 'description' => 'Editar usuarios'])->syncRoles([$role1]);
        Permission::firstOrCreate(['name' => 'users.update', 'description' => 'Actualizar información de usuarios'])->syncRoles([$role1]);
        Permission::firstOrCreate(['name' => 'users.destroy', 'description' => 'Eliminar usuarios'])->syncRoles($role1);

        //Permiso para roles
        Permission::firstOrCreate(['name' => 'roles.index', 'description' => 'Ver lista de Roles '])->syncRoles($role1);

        Permission::firstOrCreate(['name' => 'services.index', 'description' => 'Ver la lista de servicios'])->syncRoles([$role2]);
        Permission::firstOrCreate(['name' => 'services.create', 'description' => 'Crear servicios'])->syncRoles([$role2]);
        Permission::firstOrCreate(['name' => 'services.edit', 'description' => 'Editar servicios'])->syncRoles([$role2]);
        Permission::firstOrCreate(['name' => 'services.destroy', 'description' => 'Eliminar servicios'])->syncRoles([$role1, $role2]);


        // Permisos para módulo de clientes
        Permission::firstOrCreate([
            'name' => 'clientes.index',
            'description' => 'Ver lista de clientes'
        ])->syncRoles([$role1, $role2, $role3]);

        Permission::firstOrCreate([
            'name' => 'clientes.create',
            'description' => 'Registrar nuevos clientes'
        ])->syncRoles([$role1, $role2, $role3]);

        Permission::firstOrCreate([
            'name' => 'clientes.edit',
            'description' => 'Editar información de clientes'
        ])->syncRoles([$role1]);

        Permission::firstOrCreate([
            'name' => 'clientes.destroy',
            'description' => 'Eliminar clientes del sistema'
        ])->syncRoles([$role1]);

        // Permisos para módulo de mascotas
        Permission::firstOrCreate([
            'name' => 'mascotas.index',
            'description' => 'Ver lista de mascotas'
        ])->syncRoles([$role1, $role2, $role3]);

        Permission::firstOrCreate([
            'name' => 'mascotas.create',
            'description' => 'Registrar nuevas mascotas'
        ])->syncRoles([$role1, $role2, $role3]);

                
        Permission::firstOrCreate([
            'name' => 'mascotas.edit',
            'description' => 'Editar información mascotas'
        ])->syncRoles([$role1]);

        Permission::firstOrCreate([
            'name' => 'mascota.delete',
            'description' => 'Eliminar mascota'
        ])->syncRoles([$role1]);
    }
}
