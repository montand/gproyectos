<?php

use App\Periodo;
use Illuminate\Database\Seeder;

class PeriodosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Periodo::create([
         'ano'          => '2019',
         'ntope_costo'  => '100000000',
         'ntope_rh'     => '80000'
      ]);
      Periodo::create([
         'ano'          => '2020',
         'ntope_costo'  => '150000000',
         'ntope_rh'     => '100000',
         'activo'       => '1'
      ]);
    }
}
