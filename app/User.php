<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    
    const STATUS_ACTIVE = 1;
    const STATUS_BAN = 0;
    
    const  STATUS_ALL = [
        self::STATUS_ACTIVE,
        self::STATUS_BAN,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status', 'photo', 'email','name', 'phone' 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    
    public function blogPosts() 
    {
        return $this->hasMany(
                BlogPost::class,
                'user_id',
                'id');
    }
    /**
     *The function returns the url to the photo 
     * @return string
     */
    public function getPhotoUrl() 
    {
        if ($this->photo && is_file(public_path('/storage/users/' . $this->photo))) {
            return '/storage/users/' . $this->photo;            
        }
        return 'https://via.placeholder.com/200';
    }
    
    /**
     * The function checks if the user is active
     * @return boolean
     */
    public function isUserActive() 
    {
        return ($this->status == self::STATUS_ACTIVE)? TRUE:FALSE;
    }
    
    /**
     * The function checks if the user is ban
     * @return boolean
     */
    public function isUserBan() 
    {
        return ($this->status == self::STATUS_BAN)? TRUE:FALSE;
    }
    
    /**
     * A function that returns a url for a form action 
     * @return string
     */
    public function getActionUrl() 
    {
        if($this->exists){
            return route('admin.users.update', [
                'user' => $this->id
            ]);
        }
        return route('admin.users.store');  
    }
    
    
    public function deletePhotoFromStorage() 
    {
        if(isset($this->photo) && is_file(public_path('/storage/users/' .$this->photo))){
            unlink(public_path('/storage/users/' .$this->photo));
        }
        return $this;
    }
    
    /**
     * Scope a query to only include users who meet the given parameters.
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $searchTerm
     * @return \Illuminate\Database\Eloquent\Builder 
     */
    public function scopeFilterSearchTerm($query,$searchTerm) 
    {
        if(isset($searchTerm['status'])){
            $query->where('status',$searchTerm['status']);
        }
        if(isset($searchTerm['email'])){
            $query->where('email','LIKE', '%' . $searchTerm['email'] . '%');
        }
        if(isset($searchTerm['name'])){
            $query->where('name','LIKE', '%' . $searchTerm['name'] . '%');
        }
        if(isset($searchTerm['phone'])){
            $query->where('phone','LIKE', '%' . $searchTerm['phone'] . '%');
        }
        return $query;
    }
    
}
