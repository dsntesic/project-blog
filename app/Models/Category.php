<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    
    protected $fillable = ['name','description'];
    
    /**
     * A function that returns a url for a form action 
     * @return string
     */
    public function getActionUrl() 
    {
        if($this->id){
            return route('admin.categories.update', [
                'category' => $this->id
            ]);
        }
        return route('admin.categories.store');  
    }
    
    /**
     * 
     * @return int
     */
    public static function getPriorityForCategory() 
    {
       $lastInsertedCategory = self::query()
                                        ->orderBy('priority','DESC')
                                        ->first();
       return $lastInsertedCategory -> priority + 1;
    }
}

