<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Category;
use App\Models\Tag;
use App\Models\BlogPost;
use App\Models\Comment;



class TestViewComposer {
    
    
    public function compose(View $view) {
        
        $frontCategories = Cache::rememberForever(
                'frontCategories',
                function () {
                    return Category::query()
                            ->withCount([
                                  'blogPosts' =>function($query){
                                      return $query->where('status', BlogPost::STATUS_ENABLE);
                                  }
                              ])
                            ->orderBy('priority','ASC')
                            ->get();
                }
        );
        
        $frontTags = Cache::rememberForever(
                'frontTags',
                function () {
                    return Tag::query()
                            ->withCount([
                                  'blogPosts' =>function($query){
                                      return $query->where('status', BlogPost::STATUS_ENABLE);
                                  }
                            ])
                            ->orderBy('blog_posts_count','desc')
                            ->get();
                }
        );
        
        $latestBlogPosts = Cache::rememberForever(
                'latestBlogPosts',
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
        
        $latestBlogPostsWithMaxReviews = Cache::rememberForever(
                'latestBlogPostsWithMaxReviews',
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
