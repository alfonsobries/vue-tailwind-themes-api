<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CssClass;
use Faker\Generator as Faker;

$factory->define(CssClass::class, function (Faker $faker) {
    return [
        'name' => $faker->word
    ];
});
