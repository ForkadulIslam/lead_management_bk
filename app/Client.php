<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['created_by','name','address','industry','logo'];
    public function invoices(){
        return $this->hasMany('App\Invoice','member_id');
    }
    public function contact_persons(){
        return $this->hasMany('App\Contact_person');
    }
    public function creator(){
        return $this->belongsTo('App\User','created_by');
    }
    public function owner(){
        return $this->belongsToMany('App\User','client_executive','client_id','executive_id');
    }
    public function activities(){
        return $this->hasMany('App\Activity','id_of_linked_with')->where('linked_with',1);
    }
    public function deals(){
        return $this->hasMany('App\Deal');
    }
}
