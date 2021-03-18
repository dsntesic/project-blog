<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Slider;
use Faker\Generator as Faker;

$factory->define(Slider::class, function (Faker $faker) {
    
    return [
        'photo' => $faker->imageUrl(1349,800),
        'name' => $faker->company,
        'button_url' => $faker->url,
        'button_title' => $faker->domainWord,
        'created_at' => $faker->dateTimeBetween($startDate = '-6 month', $endDate = 'now', $timezone = config('app.timezone')),
        'updated_at' => $faker->dateTimeBetween($startDate = '-6 month', $endDate = 'now', $timezone = config('app.timezone'))
    ];
});
