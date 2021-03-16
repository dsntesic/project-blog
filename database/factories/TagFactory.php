<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Tag;
use Faker\Generator as Faker;

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'name' => $faker->catchPhrase,
        'created_at' => $faker->dateTimeBetween($startDate = '-6 month', $endDate = 'now', $timezone = config('app.timezone')),
        'updated_at' => $faker->dateTimeBetween($startDate = '-6 month', $endDate = 'now', $timezone = config('app.timezone'))
    ];
});
