<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * @property mixed role
 */
class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function receipts(){
        return $this->hasMany('App\Receipt');
    }
    public function promotions(){
        return $this->hasMany('App\Promotion', 'business_afm', 'afm');
    }

    public function categories(){
        return $this->hasMany('App\Category');
    }

    public function isUser(){
        return ($this->role == 'user') ? true : false;
    }
    public function isAdmin(){
        return ($this->role == 'admin') ? true : false;
    }
    public function isBusiness(){
        return ($this->role == 'business') ? true : false;
    }

}
