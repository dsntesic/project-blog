<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Models\Comment;

class BlogPostsController extends Controller
{
    public function index() 
    {

        $latestBlogPostsMain = BlogPost::query()
                                ->with([
                                    'category',
                                    'user' => function($query){
                                        return $query->isActive();
                                    },
                                    'comments' =>function($query){
                                        return $query->isEnable();
                                    }
                                ])
                                ->latestBlogPostWithStatusEnable()
                                ->paginate(12);
        
        
        return view('front.blog_posts.index',[
            'latestBlogPostsMain' => $latestBlogPostsMain,
        ]);
    }
    
    public function search(Request $request) 
    {
        $searchFormTerm = $request->validate([
            'search' => ['required','string'],
        ]);

        $blogPostsMainSearch = BlogPost::query()
                                ->with([
                                    'category',
                                    'user' => function($query){
                                        return $query->isActive();
                                    },
                                    'comments'=>function($query){
                                        return $query->isEnable();
                                    }
                                ])
                                ->latestBlogPostWithStatusEnable()
                                ->frontSearchBlogPost($searchFormTerm['search'])
                                ->paginate(12);
        return view('front.blog_posts.search',[
            'searchFormTerm' => $searchFormTerm,
            'blogPostsMainSearch' => $blogPostsMainSearch,
        ]);
    }
    
    public function single(BlogPost $blogPost,$slugUrl) 
    {
        if($blogPost->isBlogPostDisable()){
            abort(404);
        }
        
        if($slugUrl != $blogPost->getSlugUrl()){
            abort(404);
        }      
        
        $blogPost->update([
            'reviews' => $blogPost->reviews + 1,
            'updated_at' => now(),
        ]);
        
        $blogPost->load([
            'category',
            'user' => function($query){
                        return $query->isActive();
                    },
            'tags',
            'comments' => function($query){
                return $query->where('status',Comment::STATUS_ENABLE);
            }
            ]);
        
        $nextBlogPost = BlogPost::query()
                        ->where('created_at', '>', $blogPost->created_at)
                        ->where('status', BlogPost::STATUS_ENABLE)
                        ->first();
        
        $previousBlogPost = BlogPost::query()
                            ->where('created_at', '<', $blogPost->created_at)
                            ->orderBy('created_at','DESC')
                            ->first();
        
        return view('front.blog_posts.single',[
            'blogPost' => $blogPost,
            'nextBlogPost' => $nextBlogPost,
            'previousBlogPost' => $previousBlogPost,
        ]);
    }
    
     public function comments(BlogPost $blogPost) 
    {

        $blogPost->load(
                    [
                        'comments' => function($query){
                            $query->isEnable();
                        }
                    ]
                );
                    
        $commentsBlogPost = $blogPost->comments; 
        
        return view('front.blog_posts.partials.comments',[
            'commentsBlogPost' => $commentsBlogPost
        ]);
    }
       
}
