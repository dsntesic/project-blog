<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Facades\Cache;


class TagsController extends Controller
{
    
    public function single(Request $request,Tag $tag,$slugUrl) 
    {
        
        if($slugUrl != $tag->getSlugUrl()){
            return redirect()->away($tag->getSingleTag());
        }
        
        $formData = $request->validate([
            'page' =>['nullable','numeric'],
        ]);
        
        $page = !empty($formData)?$formData['page']:1;
        
        $tagByIdBlogPostsPerPage = 'tagBlogPosts' . $tag->id . $page;
        
        $$tagByIdBlogPostsPerPage = Cache::remember(
                "$tagByIdBlogPostsPerPage",
                now()->addSeconds(config('frontcachetime.tagBlogPosts')),
                function () use($tag){
                    $tagBlogPosts = $tag
                                    ->blogPosts()
                                    ->latestBlogPostWithStatusEnable()
                                    ->whereHas('tags',function($query) use ($tag){
                                        return $query->where('blog_post_tags.tag_id',$tag->id); 
                                    });
                    $tagBlogPosts->with([
                                        'category',
                                        'user' => function ($query) {
                                            return $query->isActive();
                                        },
                                        'comments' => function ($query) {
                                            return $query->isEnable();
                                        }
                                    ]);
                   return $tagBlogPostsPaginate = $tagBlogPosts->paginate(6);
                }
        );
        
        return view('front.tags.single',[
            'tag' => $tag,
            'tagBlogPostsPaginate' => $$tagByIdBlogPostsPerPage,
        ]);
    }
       
}
