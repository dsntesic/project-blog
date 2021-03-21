<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Comment;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Validator;

class CommentsController extends Controller
{
    
    public function store(Request $request) 
    {
        Cache::flush(); 
                
        $validator = Validator::make($request->all(), [
            'blog_post_id' => ['required', 'numeric','exists:blog_posts,id'],
            'name' => ['required', 'string','max:50'],
            'email' => ['required', 'email','max:255'],
            'message' => ['required', 'string'],
        ]);
        
        $blogPost = BlogPost::findOrFail($request->blog_post_id);
        
        if ($validator->fails()) {
            return  view('front.blog_posts.partials.comment_form',[
                'blogPost' => $blogPost,
                'errors' => $validator->errors()
            ]);
        }
        $newComment = new Comment($validator->valid());
        
        $newComment->save();
            
        return view('front.blog_posts.partials.comment_form',[
            'blogPost' =>$blogPost,
            'system_message' => __('Comment has been created successfully')
        ]);
    }
    
       
}
