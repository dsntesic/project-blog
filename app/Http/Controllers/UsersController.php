<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\User;

class UsersController extends Controller
{
    
    public function single(User $user,$slugUrl) 
    {
        if($user->isUserBan()){
            abort(404);
        }
        
        if($slugUrl != $user->getSlugUrl()){
            abort(404);
        }
        
        $userBlogPosts = BlogPost::query()
            ->with([
                'category',
                'user' => function ($query) {
                    return $query->isActive();
                },
                'comments' => function ($query) {
                    return $query->isEnable();
                }
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
