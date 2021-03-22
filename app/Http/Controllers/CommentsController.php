<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Validator;

class CommentsController extends Controller
{
    
    public function store(Request $request) 
    {
                
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string','max:50'],
            'email' => ['required', 'email','max:255'],
            'blog_post_id' => ['required', 'numeric','exists:blog_posts,id'],
            'message' => ['required', 'string' ,'max:500'],
        ]);
        
        $blogPost = BlogPost::findOrFail($request->blog_post_id);
        
        if ($validator->fails()) {
            return  view('front.blog_posts.partials.comment_form',[
                'request' => $request, 
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
