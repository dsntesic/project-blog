<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Tag;
use App\Models\BlogPost;
use App\User;

class CategoriesController extends Controller
{
    
    public function single(Category $category) 
    {
        $categoryBlogPosts = BlogPost::query()
            ->with(
                ['user' => function ($query) {
                    return $query->where('users.status', User::STATUS_ACTIVE);
                }] 
            )
            ->where('category_id',$category->id)
            ->latestBlogPostWithStatusEnable()
            ->paginate(12);
        $latestBlogPostsWithMaxReviews = BlogPost::query()
                                        ->with(['category'])
                                        ->sortByMaxReviewsForOneMonth()
                                        ->limit(3)
                                        ->get();
        $latestBlogPosts = BlogPost::query()
                            ->latestBlogPostWithStatusEnable()
                            ->limit(12)
                            ->get();
        
        $frontCategories = Category::query()
                      ->withCount(['blogPosts' => function($query){
                          return $query->where('blog_posts.status', BlogPost::STATUS_ENABLE);
                      }])
                      ->orderBy('priority','ASC')
                      ->get();
        
        $frontTags = Tag::query()
                      ->withCount(['blogPosts' => function($query){
                          return $query->where('blog_posts.status', BlogPost::STATUS_ENABLE);
                      }])
                      ->orderBy('blog_posts_count','desc')
                      ->get();
        return view('front.categories.single',[
            'category' => $category,
            'categoryBlogPosts' => $categoryBlogPosts,
            'latestBlogPostsWithMaxReviews' => $latestBlogPostsWithMaxReviews,
            'latestBlogPosts' => $latestBlogPosts,
            'frontCategories' => $frontCategories,
            'frontTags' => $frontTags,
        ]);
    }
       
}
