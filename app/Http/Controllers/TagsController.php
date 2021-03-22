<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\BlogPost;

class TagsController extends Controller
{
    
    public function single(Tag $tag,$slugUrl) 
    {
        
        if($slugUrl != $tag->getSlugUrl()){
            abort(404);
        }
        
        $tagBlogPosts = BlogPost::query()
            ->with([
                'category',
                'user' => function($query){
                    return $query->isActive();
                },
                'comments' => function ($query) {
                    return $query->isEnable();
                }
            ])
            ->latestBlogPostWithStatusEnable()
            ->whereHas('tags',function($query) use ($tag){
                return $query->where('blog_post_tags.tag_id',$tag->id); 
            })
            ->paginate(12);
        return view('front.tags.single',[
            'tag' => $tag,
            'tagBlogPosts' => $tagBlogPosts,
        ]);
    }
       
}
