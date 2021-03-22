<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\BlogPost;

class CategoriesController extends Controller
{
    
    public function single(Category $category,$slugUrl) 
    {
        
        if($slugUrl != $category->getSlugUrl()){
            abort(404);
        }
        
        $categoryBlogPosts = BlogPost::query()
                            ->with([
                                'category',
                                'user' => function ($query) {
                                    return $query->isActive();
                                },
                                'comments' => function ($query) {
                                    return $query->isEnable();
                                }
                            ])
                            ->where('category_id',$category->id)
                            ->latestBlogPostWithStatusEnable()
                            ->paginate(12);
        
        return view('front.categories.single',[
            'category' => $category,
            'categoryBlogPosts' => $categoryBlogPosts,
        ]);
    }
       
}
