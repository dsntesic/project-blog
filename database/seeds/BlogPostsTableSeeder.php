<?php

use Illuminate\Database\Seeder;
use App\Models\BlogPost;
use App\Models\Tag;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class BlogPostsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('blog_posts')->truncate();
        $faker = Faker::create();
        factory(BlogPost::class, 30)
            ->create()
            ->each(function($blogPost) use($faker){
                $tagRandomIds = Tag::pluck('id')->random(rand(1,4));
                $tagRandomIdsWithTimestamps = [];
                foreach ($tagRandomIds as $id) {

                    $tagRandomIdsWithTimestamps[$id] = 
                        [
                            'created_at' => $faker->dateTimeBetween($startDate = '-6 month', $endDate = 'now', $timezone = config('app.timezone')),
                            'updated_at' => $faker->dateTimeBetween($startDate = '-6 month', $endDate = 'now', $timezone = config('app.timezone'))
                        ];
                }
                $blogPost->tags()->sync(
                    $tagRandomIdsWithTimestamps
                );
            });
        }
    }
    