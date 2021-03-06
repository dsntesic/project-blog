<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected  $table = 'tags';
    
    protected  $fillable = ['name'];



    public function blogPosts() 
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
        if($this->exists){
            return route('admin.tags.update', [
                'tag' => $this->id
            ]);
        }
        return route('admin.tags.store');  
    }
    
    /**
     * A function that returns a url for a single tag
     * @return string
     */
    public function getSingleTag() {
        return route('front.tags.single',[
            'tag' => $this->id,
            'tagSlugName' => $this->getSlugUrl(),
        ]);
    }
    
    /**
     * A function that returns a slug
     * @return string
     */
    public function getSlugUrl() {
        
        return \Str::slug($this->name);
    }
}
