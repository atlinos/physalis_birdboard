<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Person;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Person::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'firstname' => $faker->firstName,
        'gender' => $faker->randomElement(['M', 'F']),
        'profession' => $faker->jobTitle,
        'birthplace' => $faker->city,
        'birthdate' => $faker->date(),
        'death_place' => $faker->city,
        'death_date' => $faker->date(),
        'death_age' => $faker->randomNumber(2),
        'project_id' => function () {
            return factory('App\Project')->create()->id;
        }
    ];
});
