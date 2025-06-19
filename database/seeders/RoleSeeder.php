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

            // Categorias
            ['name' => 'categorias.index', 'description' => 'Ver lista de categorias',          'roles' => ['Admin', 'Veterinario', 'Recepcionista']],
            ['name' => 'categorias.create', 'description' => 'registar nuevas categorias',        'roles' => ['Admin','Recepcionista']],
            ['name' => 'categorias.edit', 'description' => 'Editar informacion de categoias',  'roles' => ['Admin','Recepcionista']],
            ['name' => 'categorias.destroy', 'description' => 'Eliminar categoias',  'roles' => ['Admin','Recepcionista']],

            // Proveedor
            ['name' => 'proveedor.index', 'description' => 'Ver lista de Proveedor',          'roles' => ['Admin', 'Veterinario', 'Recepcionista']],
            ['name' => 'proveedor.create', 'description' => 'registar nuevas Proveedor',        'roles' => ['Admin']],
            ['name' => 'proveedor.edit', 'description' => 'Editar informacion de Proveedor',  'roles' => ['Admin']],
            ['name' => 'proveedor.destroy', 'description' => 'Eliminar Proveedor',              'roles' => ['Admin']],

            // Productos
            ['name' => 'productos.index', 'description' => 'Ver lista de productos',          'roles' => ['Admin', 'Veterinario', 'Recepcionista']],
            ['name' => 'productos.create', 'description' => 'registar nuevas productos',        'roles' => ['Admin','Recepcionista']],
            ['name' => 'productos.edit', 'description' => 'Editar informacion de productos',  'roles' => ['Admin','Recepcionista']],
            ['name' => 'productos.destroy', 'description' => 'Eliminar productos',              'roles' => ['Admin','Recepcionista']],

            // Entrada
            ['name' => 'entrada.index', 'description' => 'Ver lista de entrada',          'roles' => ['Admin', 'Veterinario', 'Recepcionista']],
            ['name' => 'entrada.create', 'description' => 'registar nuevas entrada',        'roles' => ['Admin','Recepcionista']],
            ['name' => 'entrada.edit', 'description' => 'Editar informacion de entrada',  'roles' => ['Admin','Recepcionista']],
            ['name' => 'entrada.destroy', 'description' => 'Eliminar entrada',              'roles' => ['Admin','Recepcionista']],

            // Ventas
            ['name' => 'ventas.index', 'description' => 'Ver lista de ventas',          'roles' => ['Admin', 'Veterinario', 'Recepcionista']],
            ['name' => 'ventas.create', 'description' => 'registar nuevas ventas',        'roles' => ['Admin','Recepcionista']],

            // Historial
            ['name' => 'historial.index', 'description' => 'Ver historial de ventas',          'roles' => ['Admin', 'Veterinario', 'Recepcionista']],
            ['name' => 'historial.destroy', 'description' => 'Eliminar venta',              'roles' => ['Admin']],

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
