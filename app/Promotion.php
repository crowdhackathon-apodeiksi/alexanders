<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model {

    protected $fillable=['title', 'type', 'receipts_count', 'money_count', 'business_afm'];

}
