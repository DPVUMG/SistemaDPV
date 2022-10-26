<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Municipio;
use App\Models\Persona;
use App\Models\Usuario;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Persona::class, function (Faker $faker) {
    $municipio = Municipio::all()->random()->first();
    return [
        'cui' => $faker->unique()->numerify('#############'),
        'nombre' => $faker->randomElement([$faker->name('male'), $faker->name('female')]),
        'apellido' => $faker->randomElement([$faker->firstName('male'), $faker->firstName('female')]),
        'telefono' => $faker->numerify('#######'),
        'correo_electronico' => $faker->unique()->freeEmail,
        'direccion' => "{$faker->streetAddress}, {$faker->streetName}, {$faker->city}",
        'departamento_id' => $municipio->departamento_id,
        'municipio_id' => $municipio->id
    ];
});

$factory->define(Usuario::class, function (Faker $faker) {


    do {
        $persona = Persona::all()->random()->id;
    } while (Usuario::where('persona_id', $persona)->first() != null);

    return [
        'password' => 'admin',
        'usuario' => $faker->unique()->userName,
        'persona_id' => $persona,
        'remember_token' => Str::random(10)
    ];
});
