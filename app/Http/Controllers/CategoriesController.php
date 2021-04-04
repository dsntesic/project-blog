<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoriesController extends Controller
{
    
    public function single(Request $request,Category $category,$slugUrl) 
    {
        
        if($slugUrl != $category->getSlugUrl()){
            return redirect()->away($category->getSingleCategory());
        }
        
        $formData = $request->validate([
            'page' =>['nullable','numeric'],
        ]);
        $page = !empty($formData)?$formData['page']:1;
        
        $categoryByIdBlogPostsPerPage = 'categoryBlogPosts' . $category->id . $page;
        
        $categoryBlogPostsPaginate = Cache::remember(
                "$categoryByIdBlogPostsPerPage",
                now()->addSeconds(config('frontcachetime.categoryBlogPosts')),
                function () use($category){
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
                        return $categoryBlogPostsPaginate = $categoryBlogPosts->paginate(2);
                }
        );
        
        return view('front.categories.single',[
            'category' => $category,
            'categoryBlogPostsPaginate' => $categoryBlogPostsPaginate,
        ]);
    }
       
}
