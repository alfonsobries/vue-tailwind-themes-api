<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Models\Theme;
use Faker\Generator as Faker;

$factory->define(Theme::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create();
        },
        'name' => $faker->sentence(2),
        'description' => $faker->sentence(12),
        'settings' => '{}',
    ];
});
