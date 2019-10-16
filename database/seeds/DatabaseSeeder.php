<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CriteriosTableSeeder::class);
        $this->call(ProyectosTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
