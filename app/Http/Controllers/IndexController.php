<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\BlogPost;
use App\Models\Slider;

class IndexController extends Controller
{
    public function index() 
    {
        
        $latestSliders = Slider::query()
                         ->where('status', Slider::STATUS_ENABLE)
                         ->orderBy('priority','ASC')
                         ->get();
        $featuredBlogPosts = BlogPost::query()
                           ->with(['category','user'])
                           ->where('important', BlogPost::IMPORTANT_YES)
                           ->latestBlogPostWithStatusEnable()
                           ->limit(3)
                           ->get();
        $latestBlogPosts = BlogPost::query()
                           ->with(['category'])
                           ->latestBlogPostWithStatusEnable()
                           ->limit(12)
                           ->get();
        $frontCategories = Category::query()
                            ->orderBy('priority','ASC')
                            ->get();
        return view('front.index.index',[
            'latestSliders' => $latestSliders,
            'featuredBlogPosts' => $featuredBlogPosts,
            'latestBlogPosts' => $latestBlogPosts,
            'frontCategories' => $frontCategories,
        ]);
    }
}
