<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class UsersController extends Controller
{
    
    public function single(Request $request,User $user,$slugUrl) 
    {
        if($user->isUserBan()){
            abort(404);
        }
        
        if($slugUrl != $user->getSlugUrl()){
            return redirect()->away($user->getSingleUser());
        }
        
        $formData = $request->validate([
            'page' =>['nullable','numeric'],
        ]);
        
        $page = !empty($formData)?$formData['page']:1;
        
        $userByIdBlogPostsPerPage = 'userBlogPosts' . $user->id . $page;
        
        $$userByIdBlogPostsPerPage = Cache::remember(
                "$userByIdBlogPostsPerPage",
                now()->addSeconds(config('frontcachetime.userBlogPosts')),
                function () use($user){
                    $userBlogPosts = $user
                                    ->blogPosts()
                                    ->latestBlogPostWithStatusEnable();
                    $userBlogPosts->with([
                                        'category',
                                        'user' => function ($query) {
                                            return $query->isActive();
                                        },
                                        'comments' => function ($query) {
                                            return $query->isEnable();
                                        }
                                    ]);
                    $userBlogPostsPaginate = $userBlogPosts->paginate(2);
                    return $userBlogPostsPaginate;
                }
        );
        
        return view('front.users.single',[
            'user' => $user,
            'userBlogPostsPaginate' => $$userByIdBlogPostsPerPage,
        ]);
    }
       
}
