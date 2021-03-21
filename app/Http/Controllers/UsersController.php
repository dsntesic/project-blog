<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\User;

class UsersController extends Controller
{
    
    public function single(User $user) 
    {
        if($user->isUserBan()){
            abort(404);
        }
        $userBlogPosts = BlogPost::query()
            ->with([
                'user',
                'category'
                ])
            ->latestBlogPostWithStatusEnable()
            ->where('user_id',$user->id)
            ->paginate(12);
        return view('front.users.single',[
            'user' => $user,
            'userBlogPosts' => $userBlogPosts,
        ]);
    }
       
}
