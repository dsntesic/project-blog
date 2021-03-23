<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class CommentsController extends Controller
{
    
    public function store(Request $request) 
    {
        
        Cache::forget('latestBlogPostsWithMaxReviews');
                
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string','max:50'],
            'email' => ['required', 'email','max:255'],
            'blog_post_id' => ['required', 'numeric','exists:blog_posts,id'],
            'message' => ['required', 'string' ,'max:500'],
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ],422);
        }
        $newComment = new Comment($validator->valid());
        
        $newComment->save();
        
        return response()->json([
            'blog_post_id' => $request->blog_post_id,
            'system_message' => __('Comment has been created successfully')
        ]);
    }
    
       
}
