<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Category;
use App\Models\Tag;
use App\Models\BlogPost;
use App\Models\Comment;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
        view()->composer("*","App\Http\ViewComposers\TestViewComposer");
        /*View::share([
            'frontCategories' => $frontCategories,
            'frontTags' => $frontTags,
            'latestBlogPosts' => $latestBlogPosts,
            'latestBlogPostsWithMaxReviews' => $latestBlogPostsWithMaxReviews,
        ]);*/
    }
}
