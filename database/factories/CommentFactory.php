<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comment;
use App\Models\BlogPost;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    $blogPostRandomId = BlogPost::pluck('id')->random();
    return [
        'status' => rand(0,1),
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'blog_post_id' => $blogPostRandomId,
        'message' => $faker->realText(255),
        'created_at' => $faker->dateTimeBetween($startDate = '-6 month', $endDate = 'now', $timezone = config('app.timezone')),
        'updated_at' => $faker->dateTimeBetween($startDate = '-6 month', $endDate = 'now', $timezone = config('app.timezone'))
    ];
});
