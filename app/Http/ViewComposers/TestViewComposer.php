<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Category;
use App\Models\Tag;
use App\Models\BlogPost;



class TestViewComposer {
    
    
    public function compose(View $view) {
        
        $frontCategories = Cache::remember(
                'frontCategories',
                now()->addSeconds(config('frontcachetime.frontCategories')),
                function () {
                    return Category::query()
                            ->withCount([
                                  'blogPosts' =>function($query){
                                      return $query->isEnable();
                                  }
                              ])
                            ->orderBy('priority','ASC')
                            ->get();
                }
        );
        
        $frontTags = Cache::remember(
                'frontTags',
                now()->addSeconds(config('frontcachetime.frontTags')),
                function () {
                    return Tag::query()
                            ->withCount([
                                'blogPosts' =>function($query){
                                    return $query->isEnable();
                                }
                            ])
                            ->orderBy('blog_posts_count','desc')
                            ->get();
                }
        );
        
        $latestBlogPosts = Cache::remember(
                'latestBlogPosts',
                now()->addSeconds(config('frontcachetime.latestBlogPosts')),
                function () {
                    return BlogPost::query()
                            ->with([
                                'category',
                                'user' => function($query){
                                    return $query->isActive();
                                }
                            ])
                            ->latestBlogPostWithStatusEnable()
                            ->limit(12)
                            ->get();
                }
        );
        
        $latestBlogPostsWithMaxReviews = Cache::remember(
                'latestBlogPostsWithMaxReviews',
                now()->addSeconds(config('frontcachetime.latestBlogPostsWithMaxReviews')),
                function () {
                    return BlogPost::query()
                            ->with([
                                'category',
                                'user' => function($query){
                                    return $query->isActive();
                                },
                                'comments' =>function($query){
                                    return  $query->isEnable();
                                }
                                ])
                            ->sortByMaxReviewsForOneMonth()
                            ->limit(3)
                            ->get();
                }
        );
        $view->with([
            'frontCategories' => $frontCategories,
            'frontTags' => $frontTags,
            'latestBlogPosts' => $latestBlogPosts,
            'latestBlogPostsWithMaxReviews' => $latestBlogPostsWithMaxReviews,           
        ]);
    }
}
