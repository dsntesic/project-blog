<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class BlogPost extends Model {

    protected $table = 'blog_posts';
    
    protected $fillable = ['status','name', 'description', 'content', 'category_id','reviews','created_at','updated_at'];

    const STATUS_ENABLE = 1;
    
    const STATUS_DISABLE = 0;
    
    const STATUS_ALL = [
        self::STATUS_ENABLE,
        self::STATUS_DISABLE,
    ];
    
    const IMPORTANT_YES = 1;
    
    const IMPORTANT_NO = 0;
    
    const IMPORTANT = [
        self::IMPORTANT_YES,
        self::IMPORTANT_NO,
    ];

    public function user() 
    {
        return $this->belongsTo(
                        User::class, 
                        'user_id',
                        'id');
    }
    
    public function comments() 
    {
        return $this->hasMany(
                Comment::class,
                'blog_post_id',
                'id');
    }

    /**
     * Get the category that owns the blog post.
     */
    public function category() 
    {

        return $this->belongsTo(
                        Category::class, 
                        'category_id',
                        'id'
                );
    }

    public function tags() 
    {
        return $this->belongsToMany(
                        Tag::class, 
                        'blog_post_tags', 
                        'blog_post_id', 
                        'tag_id',
                        'id'
                );
    }

    /**
     * The function returns the url to the thumb photo 
     * @return string
     */
    public function getPhotoThumbUrl() {
        if ($this->photo) {
            if(is_file(public_path('/storage/blog_posts/thumbs/' . $this->photo))){
                return url('/storage/blog_posts/thumbs/' . $this->photo);
            }
            return url($this->photo);
        }
        return url('https://via.placeholder.com/256');
    }

    /**
     * The function returns the url to the photo 
     * @return string
     */
    public function getPhotoUrl() {
        if ($this->photo) {
            if(is_file(public_path('/storage/blog_posts/' . $this->photo))){
                return url('/storage/blog_posts/' . $this->photo);
            }
            return url($this->photo);
        }
        return url('https://via.placeholder.com/640');
    }

    /**
     * A function that returns a url for a form action 
     * @return string
     */
    public function getActionUrl() {
        if ($this->exists) {
            return route('admin.blog_posts.update', [
                'blogPost' => $this->id
            ]);
        }
        return route('admin.blog_posts.store');
    }
    
    /**
     * A function that returns a url for a single blog post 
     * @return string
     */
    public function getSingleBlogPost() {
        return route('front.blog_posts.single',[
            'blogPost' => $this->id,
            'blogPostSlugName' => \Str::slug($this->name),
        ]);
    }
    
    /**
     * A function that returns a date in  format type e.g  1 day ago
     * @return string
     */
    public function getFormatHumansDate() {
        
        return \Carbon\Carbon::parse($this->created_at)->diffForHumans();
    }
    
    /**
     * A function that returns a date in  format type e.g  January 1 | 2004
     * @return string
     */
    public function getFormatDate() {
        
        return \Carbon\Carbon::parse($this->created_at)->format('F d | Y');
    }
    
    /**
     * A function that returns a date in  format type e.g  January 1 , 2004
     * @return string
     */
    public function getFooterFormatDate() {
        
        return \Carbon\Carbon::parse($this->created_at)->format('F d , Y');
    }
    
    /**
     * The function returns the number of comments for a given blog post
     * @return string
     */
    public function getCountComments() {
        
        return $this->comments->count();
    }
    
    /**
     * A function that returns a limited name
     * @return string
     */
    public function getStrName() {
        
        return \Str::limit($this->name,50);
    }
    /**
     * A function that returns a limited description
     * @return string
     */
    public function getStrDescription() {
        
        return \Str::limit($this->description,150);
    }
    
    /**
     * The function checks if the blog post is enable
     * @return boolean
     */
    public function isBlogPostEnable() {
        return ($this->status == self::STATUS_ENABLE) ? TRUE : FALSE;
    }

    /**
     * The function checks if the blog post is disable
     * @return boolean
     */
    public function isBlogPostDisable() {
        return ($this->status == self::STATUS_DISABLE) ? TRUE : FALSE;
    }

    /**
     * The function checks if the blog post is important
     * @return boolean
     */
    public function isBlogPostImportant() {
        return ($this->important == self::IMPORTANT_YES) ? TRUE : FALSE;
    }

    public function deletePhotoFromStorage() {
        if (isset($this->photo) && is_file(public_path('/storage/blog_posts/' . $this->photo))) {
            unlink(public_path('/storage/blog_posts/' . $this->photo));
            unlink(public_path('/storage/blog_posts/thumbs/' . $this->photo));
        }
        return $this;
    }

    /**
     * Scope a query to only include Blog Posts who meet the given parameters.
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $searchTerm
     * @return \Illuminate\Database\Eloquent\Builder 
     */
    public function scopeFilterSearchTerm($query, $searchTerm) {
        if (isset($searchTerm['name'])) {
            $query->where('blog_posts.name', 'LIKE', '%' . $searchTerm['name'] . '%');
        }
        if (isset($searchTerm['category_id'])) {
            $query->where('blog_posts.category_id', '=', $searchTerm['category_id']);
        }
        if (isset($searchTerm['user_id'])) {
            $query->where('blog_posts.user_id', $searchTerm['user_id']);
        }
        if (isset($searchTerm['status'])) {
            $query->where('blog_posts.status', '=', $searchTerm['status']);
        }
        if (isset($searchTerm['important'])) {
            $query->where('blog_posts.important', '=', $searchTerm['important']);
        }
        if (isset($searchTerm['tag_id']) && is_array($searchTerm['tag_id'])) {
            $query->whereHas('tags', function($subQuery) use ($searchTerm) {
                $subQuery->whereIn('blog_post_tags.tag_id', $searchTerm['tag_id']);
            });
        }
        return $query;
    }
    
    /**
     * Scope a query to only include latest enable blog post.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLatestBlogPostWithStatusEnable($query) {
        
        return $query->where('status', self::STATUS_ENABLE)
                     ->latest();
    }
    
    /**
     * Scope a query to only include blog post with max reviews for a month.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortByMaxReviewsForOneMonth($query) {
        
        return $query->where('status', self::STATUS_ENABLE)
                     ->whereBetween('updated_at', [now()->subMonth(), now()])
                     ->orderBy('reviews','DESC');
    }
    
    /**
     * Scope a query to only include blog posts which contains the key word in its description, title, content.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFrontSearchBlogPost($query,$search) {
        
        return $query->where(function ($query) use ($search) {
                        $query->orWhere('name','LIKE','%' . $search . '%')
                              ->orWhere('description','LIKE','%' . $search . '%')
                              ->orWhere('content','LIKE','%' . $search . '%');
                     });
    }
    
    /**
     * Scope a query to only include blog post who is active.
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder 
     */
    public function scopeIsEnable($query) 
    {
        
        return $query->where('status', self::STATUS_ENABLE);
    }

}
