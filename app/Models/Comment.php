<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BlogPost;

class Comment extends Model
{
   
    protected $table = 'comments';
    
    protected $fillable = ['name','email','message','blog_post_id'];
    
    const STATUS_ENABLE = 1;
    
    const STATUS_DISABLE = 0;
    
    const STATUS_ALL = [
        self::STATUS_ENABLE,
        self::STATUS_DISABLE,
    ];
    
    /**
     * Get the blog post that owns the comment.
     */
    public function blogPost() 
    {
        return $this->belongsTo(
                        BlogPost::class, 
                        'blog_post_id',
                        'id');
    }
    
    /**
     * The function checks if the comment is enable
     * @return boolean
     */
    public function isCommentEnable() {
        return ($this->status == self::STATUS_ENABLE) ? TRUE : FALSE;
    }

    /**
     * The function checks if the comment is disable
     * @return boolean
     */
    public function isCommentDisable() {
        return ($this->status == self::STATUS_DISABLE) ? TRUE : FALSE;
    }
    
    /**
     * A function that returns a date in  format type e.g  January  2004
     * @return string
     */
    public function getFormatDate() {
        
        return \Carbon\Carbon::parse($this->created_at)->format('F Y');
    }
    
    /**
     * Scope a query to only include Comments who meet the given parameters.
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $searchTerm
     * @return \Illuminate\Database\Eloquent\Builder 
     */
    public function scopeFilterSearchTerm($query, $searchTerm) {
        
        if (isset($searchTerm['blog_post_id'])) {
            $query->where('comments.blog_post_id', '=', $searchTerm['blog_post_id']);
        }
        if (isset($searchTerm['status'])) {
            $query->where('comments.status', '=', $searchTerm['status']);
        }
        
        return $query;
    }
    
    /**
     * Scope a query to only include comments who is active.
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder 
     */
    public function scopeIsEnable($query) 
    {
        
        return $query->where('status', self::STATUS_ENABLE);
    }
}

