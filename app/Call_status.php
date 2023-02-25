<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Call_status extends Model
{
    protected $table = 'call_status';
    protected $fillable = ['call_type','member_id','executive_id','status','remarks'];
    public function member(){
        return $this->belongsTo('App\After_sale_member','member_id');
    }

}
