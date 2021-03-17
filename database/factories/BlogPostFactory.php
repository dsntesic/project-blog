<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\BlogPost;
use App\User;
use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(BlogPost::class, function (Faker $faker) {
    $userRandomId = User::pluck('id')->random();
    $categoryRandomId = Category::pluck('id')->random();
    return [
        'name' => $faker->realText(rand(20,255)),
        'description' => $faker->realText(rand(50,500)),
        'user_id' => $userRandomId,
        'category_id' => $categoryRandomId,
        'status' => rand(0,1),
        'important' => rand(0,1),
        'created_at' => $faker->dateTimeBetween($startDate = '-6 month', $endDate = 'now', $timezone = config('app.timezone')),
        'updated_at' => $faker->dateTimeBetween($startDate = '-6 month', $endDate = 'now', $timezone = config('app.timezone'))
    ];
});
