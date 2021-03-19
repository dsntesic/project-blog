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
        
        $latestBlogPosts = BlogPost::query()
                            ->with(['category'])
                            ->latestBlogPostWithStatusEnable()
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
            'latestBlogPosts' => $latestBlogPosts,
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
        
        $latestBlogPosts = BlogPost::query()
                            ->with(['category'])
                            ->latestBlogPostWithStatusEnable()
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
            'latestBlogPosts' => $latestBlogPosts,
            'latestBlogPosts' => $latestBlogPosts,
            'frontCategories' => $frontCategories,
            'frontTags' => $frontTags,
        ]);
    }
    
}
