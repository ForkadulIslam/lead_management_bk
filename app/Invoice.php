<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['member_id','membership_package','period','l_one_category','l_two_category','amount','floating_payment_date'];
    public function member(){
        return $this->belongsTo('App\After_sale_member','member_id');
    }
    public function l_one_category_details(){
        return $this->belongsTo('App\Category','l_one_category');
    }
    public function l_two_category_details(){
        return $this->belongsTo('App\Category','l_two_category');
    }
    public function collections(){
        return $this->hasMany('App\Invoice_collection');
    }
    public function next_payment_dates(){
        return $this->hasMany('App\Next_payment_date');
    }
}
