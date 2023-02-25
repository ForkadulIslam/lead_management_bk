<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['title','start_time','end_time','remarks','type_of_activity','linked_with','id_of_linked_with','executive_id','status'];
    public function executive(){
        return $this->belongsTo('App\User','executive_id');
    }
    public function contact_persons(){
        return $this->belongsToMany('App\Contact_person','activity_contact_person','activity_id','contact_person_id');
    }
    public function client(){
        return $this->belongsto('App\Client','id_of_linked_with');
    }
    public function deal(){
        return $this->belongsto('App\Deal','id_of_linked_with');
    }
    public function individual_contact_person(){
        return $this->belongsTo('App\Contact_person','id_of_linked_with');
    }

}
