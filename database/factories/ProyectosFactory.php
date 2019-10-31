<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Proyecto::class, function (Faker $faker) {
    $cve = $faker->unique()->randomLetter;
    $cve .= $faker->unique(true)->numberBetween($min = 1, $max = 150);
    return [
        // 'cclave' => $faker->unique(true)->randomNumber($nbDigits = 3),
        'cclave' => $cve,
        'cnombre' => $faker->sentence(6),
        'cdescripcion' => $faker->text(100),
        'cjustificacion' => $faker->text(250),
        'ncosto' => $faker->randomFloat($nbMaxDecimals = 0, $min = 1000000, $max = NULL),
        'nduracion' => $faker->randomDigit,
        'unidades_rh' => $faker->numberBetween($min = 3000, $max = 200000),
    ];
});
