<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Next_payment_date extends Model
{
    protected $fillable = ['invoice_id','member_id','date','issued_by','collected_by','status','remarks'];

    public function member(){
        return $this->belongsTo('App\After_sale_member','member_id','id');
    }
    public function issued(){
        return $this->belongsTo('App\User','issued_by');
    }
    public function invoice(){
        return $this->belongsTo('App\Invoice','invoice_id');
    }
}
