<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice_collection extends Model
{
    protected $fillable = ['invoice_id','member_id','amount','payment_method','collected_by'];
    public function invoice(){
        return $this->belongsTo('App\Invoice');
    }
    public function collector(){
        return $this->belongsTo('App\User','collected_by');
    }
}
