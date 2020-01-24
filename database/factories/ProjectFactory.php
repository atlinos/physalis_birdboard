<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Project;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(4),
        'description' => $faker->sentence(4),
        'notes' => 'Foobar notes',
        'people_count' => 0,
        'owner_id' => function () {
            return factory('App\User')->create()->id;
        }
    ];
});
