<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Category;
use App\Models\BlogPost;
use App\User;

class UsersController extends Controller
{
    
    public function single(User $user) 
    {
        $userBlogPosts = BlogPost::query()
            ->with(['user','category'])
            ->latestBlogPostWithStatusEnable()
            ->where('user_id',$user->id)
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
        return view('front.users.single',[
            'user' => $user,
            'userBlogPosts' => $userBlogPosts,
            'latestBlogPostsWithMaxReviews' => $latestBlogPostsWithMaxReviews,
            'latestBlogPosts' => $latestBlogPosts,
            'frontCategories' => $frontCategories,
            'frontTags' => $frontTags,
        ]);
    }
       
}
