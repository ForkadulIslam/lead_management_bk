<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop_ad extends Model
{
    protected $fillable = [
        'shop_id','ad_id','ibs','l_one_category','l_two_category','ad_url','published_date','status',
    ];
}
