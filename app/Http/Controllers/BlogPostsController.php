<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Tag;
use App\Models\BlogPost;

class BlogPostsController extends Controller
{
    public function index(Request $request) 
    {

        $latestBlogPostsMain = BlogPost::query()
                                ->with(['category','user'])
                                ->latestBlogPostWithStatusEnable()
                                ->paginate(12);
        $latestBlogPostsWithMaxReviews = BlogPost::query()
                                        ->sortByMaxReviewsForOneMonth()
                                        ->limit(3)
                                        ->get();
        
        $latestBlogPosts = BlogPost::query()
                            ->with(['category'])
                            ->latestBlogPostWithStatusEnable()
                            ->limit(12)
                            ->get();
        
        $frontCategories = Category::query()
                      ->withCount(['blogPosts'])
                      ->orderBy('priority','ASC')
                      ->get();
        
        $frontTags = Tag::query()
                      ->withCount('blogPosts')
                      ->orderBy('blog_posts_count','desc')
                      ->get();
        return view('front.blog_posts.index',[
            'latestBlogPostsMain' => $latestBlogPostsMain,
            'latestBlogPostsWithMaxReviews' => $latestBlogPostsWithMaxReviews,
            'latestBlogPosts' => $latestBlogPosts,
            'frontCategories' => $frontCategories,
            'frontTags' => $frontTags,
        ]);
    }
    
    public function search(Request $request) 
    {
        $searchFormTerm = $request->validate([
            'search' => ['required','string'],
        ]);

        $blogPostsMainSearch = BlogPost::query()
                                ->with(['category','user'])
                                ->latestBlogPostWithStatusEnable()
                                ->frontSearchBlogPost($searchFormTerm['search'])
                                ->paginate(12);
        $latestBlogPostsWithMaxReviews = BlogPost::query()
                                        ->sortByMaxReviewsForOneMonth()
                                        ->limit(3)
                                        ->get();
        $latestBlogPosts = BlogPost::query()
                            ->with(['category'])
                            ->latestBlogPostWithStatusEnable()
                            ->limit(12)
                            ->get();
        
        $frontCategories = Category::query()
                      ->withCount(['blogPosts'])
                      ->orderBy('priority','ASC')
                      ->get();
        
        $frontTags = Tag::query()
                      ->withCount('blogPosts')
                      ->orderBy('blog_posts_count','desc')
                      ->get();
        return view('front.blog_posts.search',[
            'searchFormTerm' => $searchFormTerm,
            'blogPostsMainSearch' => $blogPostsMainSearch,
            'latestBlogPostsWithMaxReviews' => $latestBlogPostsWithMaxReviews,
            'latestBlogPosts' => $latestBlogPosts,
            'frontCategories' => $frontCategories,
            'frontTags' => $frontTags,
        ]);
    }
    
    public function single(BlogPost $blogPost) 
    {
        if($blogPost->status == BlogPost::STATUS_DISABLE){
            abort(404);
        }

        $blogPost->update([
            'reviews' => $blogPost->reviews + 1,
            'updated_at' => now(),
        ]);
        $blogPost->load(['category','user','tags']);
        
        $nextBlogPost = BlogPost::where('id', '>', $blogPost->id)
                        ->first();
        
        $previousBlogPost = BlogPost::where('id', '<', $blogPost->id)
                            ->orderBy('id','DESC')
                            ->first();
        
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
                      ->withCount(['blogPosts'])
                      ->orderBy('priority','ASC')
                      ->get();
        
        $frontTags = Tag::query()
                      ->withCount('blogPosts')
                      ->orderBy('blog_posts_count','desc')
                      ->get();
        return view('front.blog_posts.single',[
            'blogPost' => $blogPost,
            'latestBlogPostsWithMaxReviews' => $latestBlogPostsWithMaxReviews,
            'nextBlogPost' => $nextBlogPost,
            'previousBlogPost' => $previousBlogPost,
            'latestBlogPosts' => $latestBlogPosts,
            'frontCategories' => $frontCategories,
            'frontTags' => $frontTags,
        ]);
    }
       
}
