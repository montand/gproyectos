<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      // Users
      Permission::create(['name' => 'crear usuarios']);
      Permission::create(['name' => 'leer usuarios']);
      Permission::create(['name' => 'editar usuarios']);
      Permission::create(['name' => 'borrar usuarios']);

      // Roles
      Permission::create(['name' => 'crear roles']);
      Permission::create(['name' => 'leer roles']);
      Permission::create(['name' => 'editar roles']);
      Permission::create(['name' => 'borrar roles']);

      // Permisos
      Permission::create(['name' => 'crear permisos']);
      Permission::create(['name' => 'leer permisos']);
      Permission::create(['name' => 'editar permisos']);
      Permission::create(['name' => 'borrar permisos']);

      // Proyectos
      Permission::create(['name' => 'crear proyectos']);
      Permission::create(['name' => 'leer proyectos']);
      Permission::create(['name' => 'editar proyectos']);
      Permission::create(['name' => 'borrar proyectos']);

      // Criterios
      Permission::create(['name' => 'crear criterios']);
      Permission::create(['name' => 'leer criterios']);
      Permission::create(['name' => 'editar criterios']);
      Permission::create(['name' => 'borrar criterios']);

      // Elementos
      Permission::create(['name' => 'crear elementos']);
      Permission::create(['name' => 'leer elementos']);
      Permission::create(['name' => 'editar elementos']);
      Permission::create(['name' => 'borrar elementos']);

      // Temas
      Permission::create(['name' => 'crear temas']);
      Permission::create(['name' => 'leer temas']);
      Permission::create(['name' => 'editar temas']);
      Permission::create(['name' => 'borrar temas']);

      // Periodos
      Permission::create(['name' => 'crear periodos']);
      Permission::create(['name' => 'leer periodos']);
      Permission::create(['name' => 'editar periodos']);
      Permission::create(['name' => 'borrar periodos']);

      // Crear roles
      $role = Role::create(['name' => 'captura']);
      $role->givePermissionTo(['crear proyectos','leer proyectos','editar proyectos',
                              'leer criterios','leer elementos','leer temas']);

      $role = Role::create(['name' => 'moderador']);
      $role->givePermissionTo(['crear usuarios','leer usuarios','editar usuarios',
               'crear roles','leer roles','editar roles',
               'crear permisos','leer permisos','editar permisos',
               'crear proyectos','leer proyectos','editar proyectos','borrar proyectos',
               'crear criterios','leer criterios','editar criterios','borrar criterios',
               'crear elementos','leer elementos','editar elementos','borrar elementos',
               'crear temas','leer temas','editar temas','borrar temas',
               'crear periodos','leer periodos','editar periodos','borrar periodos'
            ]);

      $role = Role::create(['name' => 'super-admin']);
      $role->givePermissionTo(Permission::all());

    }
}
