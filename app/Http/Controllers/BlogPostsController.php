<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Support\Facades\Cache;

class BlogPostsController extends Controller
{
    public function index(Request $request) 
    {
        $formData = $request->validate([
            'page' =>['nullable','numeric'],
        ]);
        $page = !empty($formData)?$formData['page']:1;
        $latestBlogPostsMainName = 'latestBlogPostsMain' . $page;
        $$latestBlogPostsMainName = Cache::remember(
                "$latestBlogPostsMainName",
                now()->addSeconds(config('frontcachetime.latestBlogPostsMain')),
                function () {
                return BlogPost::query()
                    ->with([
                        'category',
                        'user' => function($query){
                            return $query->isActive();
                        },
                        'comments' =>function($query){
                            return $query->isEnable();
                        }
                    ])
                    ->latestBlogPostWithStatusEnable()
                    ->paginate(12);
                }
        );
        return view('front.blog_posts.index',[
            'latestBlogPostsMain' => $$latestBlogPostsMainName,
        ]);
    }
    
    public function search(Request $request) 
    {
        $searchFormTerm = $request->validate([
            'search' => ['required','string'],
        ]);
        $search = !empty($searchFormTerm)?$searchFormTerm['search']:'';
        $blogPostsMainSearchName = 'blogPostsMainSearch' . $search;
        $$blogPostsMainSearchName = Cache::remember(
                "$blogPostsMainSearchName",
                now()->addSeconds(config('frontcachetime.blogPostsMainSearch')),
                function () use($searchFormTerm) {
                    return BlogPost::query()
                        ->with([
                            'category',
                            'user' => function($query){
                                return $query->isActive();
                            },
                            'comments'=>function($query){
                                return $query->isEnable();
                            }
                        ])
                        ->latestBlogPostWithStatusEnable()
                        ->frontSearchBlogPost($searchFormTerm['search'])
                        ->paginate(12);
                }
        );
        return view('front.blog_posts.search',[
            'searchFormTerm' => $searchFormTerm,
            'blogPostsMainSearch' => $$blogPostsMainSearchName,
        ]);
    }
    
    public function single(BlogPost $blogPost,$slugUrl) 
    {
                
        if($blogPost->isBlogPostDisable()){
            abort(404);
        }
        
        if($slugUrl != $blogPost->getSlugUrl()){
            return redirect()->away($blogPost->getSingleBlogPost());
        }
        
        $blogPost->update([
            'reviews' => $blogPost->reviews + 1,
            'updated_at' => now(),
        ]);
        
        $singleBlogPostById = 'singleBlogPosts' . $blogPost->id;
        
        $$singleBlogPostById = $this->getSingleFrontBlogPostFromCache($blogPost,$singleBlogPostById);
       
        $nextBlogPostByBlogPostId = 'nextBlogPost' . $blogPost->id;
        
        $$nextBlogPostByBlogPostId = $this->getNextFrontBlogPostFromCache($blogPost,$nextBlogPostByBlogPostId);
        
        $previousBlogPostByBlogPostId = 'previousBlogPost' . $blogPost->id;

        $$previousBlogPostByBlogPostId = $this->getPreviousFrontBlogPostFromCache($blogPost,$previousBlogPostByBlogPostId);
        
        return view('front.blog_posts.single',[
            'blogPost' => $$singleBlogPostById,
            'nextBlogPost' => $$nextBlogPostByBlogPostId,
            'previousBlogPost' => $$previousBlogPostByBlogPostId,
        ]);
    }
    
     public function comments(BlogPost $blogPost) 
    {

        $blogPost->load(
                    [
                        'comments' => function($query){
                            $query->isEnable();
                        }
                    ]
                );
                    
        $commentsBlogPost = $blogPost->comments; 
        
        return view('front.blog_posts.partials.comments',[
            'commentsBlogPost' => $commentsBlogPost
        ]);
    }
    
    /**
     * The function returns the blog post from the cache memory, and if not takes it from the database
     * @param BlogPost $blogPost
     * @param string $singleBlogPostById
     * @return BlogPost $$singleBlogPostById
     */
    protected function getSingleFrontBlogPostFromCache(BlogPost $blogPost,$singleBlogPostById) 
    {
        
        return  Cache::remember(
                "$singleBlogPostById",
                now()->addSeconds(config('frontcachetime.singleBlogPost')),
                function () use($blogPost){
                    return $blogPost->load([
                                'user' => function($query){
                                            return $query->isActive();
                                        },
                                'tags',
                                'category',
                                'comments' => function($query){
                                    return $query->isEnable();
                                }
                            ]);
                }
        );
    }
    
    /**
     * The function returns the next blog post from the cache memory, and if not takes it from the database
     * @param BlogPost $blogPost
     * @param string $nextBlogPostByBlogPostId
     * @return BlogPost $$nextBlogPostByBlogPostId
     */
    protected function getNextFrontBlogPostFromCache(BlogPost $blogPost,$nextBlogPostByBlogPostId) 
    {
        return Cache::remember(
                "$nextBlogPostByBlogPostId",
                now()->addSeconds(config('frontcachetime.nextBlogPost')),
                function () use($blogPost){
                    return BlogPost::query()
                        ->where('created_at', '>', $blogPost->created_at)
                        ->where('status', BlogPost::STATUS_ENABLE)
                        ->orderBy('created_at', 'ASC')
                        ->first();
                }
        );
    }

    /**
     * 
     * @param BlogPost $blogPost
     * @param type $previousBlogPostByBlogPostId
     * @return BlogPost $$previousBlogPostByBlogPostId
     */
    protected function getPreviousFrontBlogPostFromCache(BlogPost $blogPost,$previousBlogPostByBlogPostId) 
    {
        return Cache::remember(
                "$previousBlogPostByBlogPostId",
                now()->addSeconds(config('frontcachetime.previousBlogPost')),
                function () use($blogPost){
                        return BlogPost::query()
                            ->where('created_at', '<', $blogPost->created_at)
                            ->latestBlogPostWithStatusEnable()
                            ->first();
                }
        );
    }

}
