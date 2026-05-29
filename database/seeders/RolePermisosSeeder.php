<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;

class RolePermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    
    {// 1. Limpiar la caché de permisos de Spatie antes de inicializar
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Crear permisos
        Permission::create(['name' => 'admin.roles.listar', 'module' => 'Administracion', 'description' => 'Es para listar roles', 'is_active' => true, 'guard_name' => 'web']);
        Permission::create(['name' => 'admin.roles.editar', 'module' => 'Administracion', 'description' => 'Es para editar roles', 'is_active' => true, 'guard_name' => 'web']);

        Permission::create(['name' => 'admin.usuarios.listar', 'module' => 'Administracion', 'description' => 'Es para listar usuarios', 'is_active' => true, 'guard_name' => 'web']);
        Permission::create(['name' => 'admin.usuarios.editar', 'module' => 'Administracion', 'description' => 'Es para editar usuarios', 'is_active' => true, 'guard_name' => 'web']);

        Permission::create(['name' => 'admin.academicos.listar', 'module' => 'Administracion', 'description' => 'Es para listar academicos', 'is_active' => true, 'guard_name' => 'web']);
        Permission::create(['name' => 'admin.academicos.editar', 'module' => 'Administracion', 'description' => 'Es para editar academicos', 'is_active' => true, 'guard_name' => 'web']);

        Permission::create(['name' => 'admin.permisos.listar', 'module' => 'Administracion', 'description' => 'Es para listar permisos', 'is_active' => true, 'guard_name' => 'web']);
        Permission::create(['name' => 'admin.permisos.editar', 'module' => 'Administracion', 'description' => 'Es para editar permisos', 'is_active' => true, 'guard_name' => 'web']);

        Permission::create(['name' => 'anteproyecto.listar', 'module' => 'Anteproyecto', 'description' => 'Es para listar anteproyectos', 'is_active' => true, 'guard_name' => 'web']);
        Permission::create(['name' => 'anteproyecto.editar', 'module' => 'Anteproyecto', 'description' => 'Es para editar anteproyectos', 'is_active' => true, 'guard_name' => 'web']);

        Permission::create(['name' => 'catalogos.categorias.listar', 'module' => 'Catálogos', 'description' => 'Es para listar categorias', 'is_active' => true, 'guard_name' => 'web']);
        Permission::create(['name' => 'catalogos.categorias.editar', 'module' => 'Catálogos', 'description' => 'Es para editar categorias', 'is_active' => true, 'guard_name' => 'web']);

        // 3. Crear roles y asignar permisos
        $roleAdmin = Role::create(['name' => 'Administrador']);
        $roleAdmin->givePermissionTo(['admin.roles.listar', 'admin.roles.editar', 'admin.usuarios.listar', 'admin.usuarios.editar', 'admin.academicos.listar', 'admin.academicos.editar', 'admin.permisos.listar', 'admin.permisos.editar', 'catalogos.categorias.listar', 'catalogos.categorias.editar']);

        // 3. Crear roles y asignar permisos
        $roleAcademico = Role::create(['name' => 'Académico']);
        $roleAcademico->givePermissionTo(['anteproyecto.listar', 'anteproyecto.editar']);


        $usuario = User::findOrFail(1);
        $usuario->assignRole($roleAdmin);

        $usuarioacad = User::findOrFail(2);
        $usuarioacad->assignRole($roleAcademico);
        
    }
}
