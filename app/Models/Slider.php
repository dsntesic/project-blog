<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model {

    protected $table = 'sliders';
    
    protected $fillable = ['name', 'button_url', 'button_title'];

    const STATUS_ENABLE = 1;
    
    const STATUS_DISABLE = 0;
    
    const STATUS_ALL = [
        self::STATUS_ENABLE,
        self::STATUS_DISABLE,
    ];

    /**
     * The function returns the url to the photo 
     * @return string
     */
    public function getPhotoUrl() {
        if ($this->photo) {
            if(is_file(public_path('/storage/sliders/' . $this->photo))){
                return url('/storage/sliders/' . $this->photo);
            }
            return url($this->photo);
        }
        return url('https://via.placeholder.com/800');
    }
    
    /**
     * The function returns the url to the slider 
     * @return string
     */
    public function getButtonUrl() {
        if ($this->button_url) {
            return url($this->button_url);
        }
        return url('https://via.placeholder.com/800');
    }

    /**
     * A function that returns a url for a form action 
     * @return string
     */
    public function getActionUrl() {
        if ($this->exists) {
            return route('admin.sliders.update', [
                'slider' => $this->id
            ]);
        }
        return route('admin.sliders.store');
    }

    /**
     * The function checks if the blog post is enable
     * @return boolean
     */
    public function isSliderEnable() {
        return ($this->status == self::STATUS_ENABLE) ? TRUE : FALSE;
    }

    /**
     * The function checks if the blog post is disable
     * @return boolean
     */
    public function isSliderDisable() {
        return ($this->status == self::STATUS_DISABLE) ? TRUE : FALSE;
    }


    public function deletePhotoFromStorage() {
        if (isset($this->photo) && is_file(public_path('/storage/sliders/' . $this->photo))) {
            unlink(public_path('/storage/sliders/' . $this->photo));
        }
        return $this;
    }
    
    /**
     * 
     * @return int
     */
    public static function getPriorityForSlider() 
    {
        $lastInsertedSlider = self::query()
                                        ->orderBy('priority','DESC')
                                        ->first();
        if(!$lastInsertedSlider){
            return 1;
        }
        return $lastInsertedSlider -> priority + 1;
    }
       

}
