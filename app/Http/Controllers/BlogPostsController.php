<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\BlogPost;
use App\Models\Comment;

class BlogPostsController extends Controller
{
    public function index(Request $request) 
    {

        $latestBlogPostsMain = BlogPost::query()
                                ->with([
                                    'category',
                                    'user',
                                    'comments' =>function($query){
                                        return $query->where('status',Comment::STATUS_ENABLE);
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
    
    public function single(BlogPost $blogPost) 
    {
        if($blogPost->isBlogPostDisable()){
            abort(404);
        }
        
        Cache::flush();       
        
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
        
        $nextBlogPost = BlogPost::where('id', '>', $blogPost->id)
                        ->first();
        
        $previousBlogPost = BlogPost::where('id', '<', $blogPost->id)
                            ->orderBy('id','DESC')
                            ->first();
        
        return view('front.blog_posts.single',[
            'blogPost' => $blogPost,
            'nextBlogPost' => $nextBlogPost,
            'previousBlogPost' => $previousBlogPost,
        ]);
    }
    
     public function comments(BlogPost $blogPost) 
    {
        Cache::flush();

        $blogPost->load(
                    [
                        'comments' => function($query){
                            $query->where('status', Comment::STATUS_ENABLE);
                        }
                    ]
                );
                    
        $commentsBlogPost = $blogPost->comments; 
        
        return view('front.blog_posts.partials.comments',[
            'commentsBlogPost' => $commentsBlogPost
        ]);
    }
       
}
