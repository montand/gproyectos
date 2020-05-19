<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      // User::truncate();
      // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

      // factory(App\User::class, 3)->create();

      $user = User::create([
         'name'   => 'Victor Lopez',
         'email'  => 'victorgera@gmail.com',
         'password' => bcrypt('mauricio')
      ]);
      $user->assignRole('super-admin');

      $user = User::create([
         'name'   => 'Moderador',
         'email'  => 'victorgera1@gmail.com',
         'password' => bcrypt('mauricio')
      ]);
      $user->assignRole('moderador');

      $user = User::create([
         'name'   => 'Captura',
         'email'  => 'victorgera6@gmail.com',
         'password' => bcrypt('mauricio')
      ]);
      $user->assignRole('captura');
      // Role::create([
      //    'name'      => 'Admin',
      //    'slug'      => 'admin',
      //    'special'   => 'all-access',
      // ]);
    }
}
