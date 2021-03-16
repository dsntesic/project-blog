<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected  $table = 'tags';
    
    protected  $fillable = ['name'];




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
