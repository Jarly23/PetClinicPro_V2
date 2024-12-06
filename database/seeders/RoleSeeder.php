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
        //
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'User']);

        Permission::create(['name' => 'dashboard'])->syncRoles([$role1,$role2]); 

        Permission::create(['name' => 'users.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.update'])->syncRoles([$role1]);

        Permission::create(['name' => 'services.index'])->syncRoles([$role2]);
        Permission::create(['name' => 'services.create'])->syncRoles([$role2]);
        Permission::create(['name' => 'services.edit'])->syncRoles([$role2]);
        Permission::create(['name' => 'services.destroy'])->syncRoles([$role1,$role2]);

        Permission::create(['name' => 'veterinarians.index'])->syncRoles([$role2]);
        Permission::create(['name' => 'veterinarians.create'])->syncRoles([$role2]);
        Permission::create(['name' => 'veterinarians.edit'])->syncRoles([$role2]);
        Permission::create(['name' => 'veterinarians.destroy'])->syncRoles([$role2]);     
    }
}
