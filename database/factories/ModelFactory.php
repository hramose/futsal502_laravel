<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\App\Entities\Persona::class, function (Faker\Generator $faker) {
    return [
        'primer_nombre' => $faker->firstName('male'),
        'segundo_nombre' => $faker->firstName('male'),
        'primer_apellido' => $faker->lastName,
        'segundo_apellido' => $faker->lastName,
        'pais_id' => 1,
        'genero' => 'M',
        'fotografia' => 'personas/male.png',
        'estado' => 'A',
        'created_by' => 'admin',
        'updated_by' => 'admin'
    ];
});

$factory->state(\App\App\Entities\Persona::class, 'jugador', function (\Faker\Generator $faker) {
	return [
    	'rol' => 'J',
    	'fecha_nacimiento' => $faker->dateTimeBetween($startDate = '-27 years', $endDate = '-20 years', $timezone = date_default_timezone_get()),
    	'posicion' => $faker->randomElement(['AD','AI','CI','PO','PI']),
  	];
});

$factory->state(\App\App\Entities\Persona::class, 'director_tecnico', function (\Faker\Generator $faker) {
	return [
    	'rol' => 'DT',
    	'fecha_nacimiento' => $faker->dateTimeBetween($startDate = '-50 years', $endDate = '-30 years', $timezone = date_default_timezone_get()),
    	'posicion' => $faker->randomElement(['DT', 'AT','PF']),
  	];
});

$factory->state(\App\App\Entities\Persona::class, 'arbitro', function (\Faker\Generator $faker) {
    return [
        'rol' => 'A',
        'fecha_nacimiento' => $faker->dateTimeBetween($startDate = '-40 years', $endDate = '-30 years', $timezone = date_default_timezone_get()),
        'posicion' => $faker->randomElement(['AR']),
    ];
});
