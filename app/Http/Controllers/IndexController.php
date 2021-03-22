<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
                           ->with([
                               'category',
                               'user' => function($query){
                                    return $query->isActive();
                                },
                               'comments' => function($query){
                                    return $query->isEnable();
                               }
                            ])
                           ->where('important', BlogPost::IMPORTANT_YES)
                           ->latestBlogPostWithStatusEnable()
                           ->limit(3)
                           ->get();
        return view('front.index.index',[
            'latestSliders' => $latestSliders,
            'featuredBlogPosts' => $featuredBlogPosts,
        ]);
    }
}
