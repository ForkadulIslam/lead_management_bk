<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = ['shop_id','shop_name','shop_profile_image','shop_url','email','total_live_ads','total_ibs','avg_response'];

    public function shop_ads(){
        return $this->hasMany('App\Shop_ad','shop_id','shop_id');
    }
}
