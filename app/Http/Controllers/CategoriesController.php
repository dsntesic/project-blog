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
            return redirect()->away($category->getSingleCategory());
        }
        
        $categoryBlogPosts = $category
                            ->blogPosts()
                            ->latestBlogPostWithStatusEnable();
        $categoryBlogPosts->with([
                                'category',
                                'user' => function ($query) {
                                    return $query->isActive();
                                },
                                'comments' => function ($query) {
                                    return $query->isEnable();
                                }
                            ]);
        $categoryBlogPostsPaginate = $categoryBlogPosts->paginate(12);
        
        return view('front.categories.single',[
            'category' => $category,
            'categoryBlogPostsPaginate' => $categoryBlogPostsPaginate,
        ]);
    }
       
}
