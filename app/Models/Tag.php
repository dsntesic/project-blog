<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected  $table = 'tags';
    
    protected  $fillable = ['name'];



    public function blog_posts() 
    {
        return $this->belongsToMany(
                BlogPost::class,
                'blog_post_tags',
                'tag_id', 
                'blog_post_id',
                'id');
    }
    
    /**
     * A function that returns a url for a form action 
     * @return string
     */
    public function getActionUrl() 
    {
        if($this->id){
            return route('admin.tags.update', [
                'tag' => $this->id
            ]);
        }
        return route('admin.tags.store');  
    }
}
