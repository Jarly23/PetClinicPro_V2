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
        // Crear roles
        $roles = [
            'Admin' => null,
            'Veterinario' => null,
            'Recepcionista' => null,
        ];

        foreach ($roles as $name => $value) {
            $roles[$name] = Role::firstOrCreate(['name' => $name]);
        }

        // Definir permisos con roles asignados
        $permissions = [
            // Usuarios
            ['name' => 'users.index',     'description' => 'Ver la lista de usuarios',         'roles' => ['Admin']],
            ['name' => 'users.edit',      'description' => 'Editar usuarios',                 'roles' => ['Admin']],
            ['name' => 'users.update',    'description' => 'Actualizar información de usuarios', 'roles' => ['Admin']],
            ['name' => 'users.destroy',   'description' => 'Eliminar usuarios',               'roles' => ['Admin']],

            // Roles
            ['name' => 'roles.index',     'description' => 'Ver lista de roles',              'roles' => ['Admin']],

            // Servicios
            ['name' => 'services.index',  'description' => 'Ver la lista de servicios',       'roles' => ['Veterinario']],
            ['name' => 'services.create', 'description' => 'Crear servicios',                 'roles' => ['Veterinario']],
            ['name' => 'services.edit',   'description' => 'Editar servicios',                'roles' => ['Veterinario']],
            ['name' => 'services.destroy', 'description' => 'Eliminar servicios',              'roles' => ['Admin', 'Veterinario']],

            // Clientes
            ['name' => 'clientes.index',  'description' => 'Ver lista de clientes',           'roles' => ['Admin', 'Veterinario', 'Recepcionista']],
            ['name' => 'clientes.create', 'description' => 'Registrar nuevos clientes',       'roles' => ['Admin', 'Veterinario', 'Recepcionista']],
            ['name' => 'clientes.edit',   'description' => 'Editar información de clientes',  'roles' => ['Admin']],
            ['name' => 'clientes.destroy', 'description' => 'Eliminar clientes del sistema',   'roles' => ['Admin']],

            // Mascotas
            ['name' => 'mascotas.index',  'description' => 'Ver lista de mascotas',           'roles' => ['Admin', 'Veterinario', 'Recepcionista']],
            ['name' => 'mascotas.create', 'description' => 'Registrar nuevas mascotas',       'roles' => ['Admin', 'Veterinario', 'Recepcionista']],
            ['name' => 'mascotas.edit',   'description' => 'Editar información mascotas',     'roles' => ['Admin']],
            ['name' => 'mascotas.destroy', 'description' => 'Eliminar mascota',                'roles' => ['Admin']],

            // Consultas
            ['name' => 'consultas.index', 'description' => 'Ver lista de consultas',          'roles' => ['Admin', 'Veterinario', 'Recepcionista']],
            ['name' => 'consultas.create', 'description' => 'Registrar nuevas consultas',      'roles' => ['Admin', 'Veterinario', 'Recepcionista']],
            ['name' => 'consultas.edit', 'description' => 'Editar informacion de consultas',  'roles' => ['Admin']],
            ['name' => 'consultas.destroy', 'description' => 'Eliminar consultas',  'roles' => ['Admin']],

            // Reservas
            ['name' => 'reservas.index', 'description' => 'Ver lista de reservas',          'roles' => ['Admin', 'Veterinario', 'Recepcionista']],
            ['name' => 'reservas.create', 'description' => 'Registrar nuevas reservas',      'roles' => ['Admin', 'Veterinario', 'Recepcionista']],
            ['name' => 'reservas.edit', 'description' => 'Editar informacion de reservas',  'roles' => ['Admin']],
            ['name' => 'reservas.destroy', 'description' => 'Eliminar reservas',  'roles' => ['Admin']],

            // Servicios
            ['name' => 'servicios.index', 'description' => 'Ver lista de servicios',          'roles' => ['Admin', 'Veterinario', 'Recepcionista']],
            ['name' => 'servicios.create', 'description' => 'Registrar nuevos servicios',      'roles' => ['Admin', 'Veterinario', 'Recepcionista']],
            ['name' => 'servicios.edit', 'description' => 'Editar informacion de servicios',  'roles' => ['Admin']],
            ['name' => 'servicios.destroy', 'description' => 'Eliminar servicios',  'roles' => ['Admin']],

        ];

        // Crear permisos y asignar roles
        foreach ($permissions as $perm) {
            $permission = Permission::firstOrCreate([
                'name' => $perm['name']
            ], [
                'description' => $perm['description']
            ]);

            $permission->syncRoles(array_map(fn($r) => $roles[$r], $perm['roles']));
        }
    }
}
