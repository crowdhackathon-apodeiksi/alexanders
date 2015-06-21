<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed categories
 */
class Receipt extends Model {

    protected $fillable=['aa', 'afm', 'eponimia', 'poso', 'image', 'printed_at', 'user_id'];
    protected $hidden = [];

    public function getDates()
    {
        return ['created_at', 'updated_at', 'printed_at'];
    }

    public function owner(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'receipt_category');
    }

    public function hasCategory($category){
        foreach($this->categories as $receipt_category){
            if($receipt_category->id == $category->id)
                return true;
        }
        return false;
    }
}
