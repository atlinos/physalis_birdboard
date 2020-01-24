<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Person;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Person::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'firstname' => $faker->firstName,
        'project_id' => function () {
            return factory('App\Project')->create()->id;
        }
    ];
});
