<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    
    protected $fillable = ['name','description'];
    
    /**
    * Get the blog posts for the category.
    */
    public function blogPosts() 
    {
        
       return $this->hasMany(
               BlogPost::class,
               'category_id',
               'id');
    }
    /**
     * A function that returns a url for a form action 
     * @return string
     */
    public function getActionUrl() 
    {
        if($this->exists){
            return route('admin.categories.update', [
                'category' => $this->id
            ]);
        }
        return route('admin.categories.store');  
    }
    
    /**
     * A function that returns a url for a single category
     * @return string
     */
    public function getSingleCategory() {
        return route('front.categories.single',[
            'category' => $this->id,
            'categorySlugName' => $this->getSlugUrl(),
        ]);
    }
    
    /**
     * A function that returns a slug
     * @return string
     */
    public function getSlugUrl() {
        
        return \Str::slug($this->name);
    }
    
    /**
     *A function that sets the category by priority
     * @return int
     */
    public static function getPriorityForCategory() 
    {
        $lastInsertedCategory = self::query()
                                        ->orderBy('priority','DESC')
                                        ->first();
        if(!$lastInsertedCategory){
            return 1;
        }
        return $lastInsertedCategory -> priority + 1;
    }
}

