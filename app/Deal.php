<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Deal extends Model
{
    protected $fillable = ['created_by','client_id','title','amount','creation_date','closing_date','stage','remarks'];
    public function client(){
        return $this->belongsTo('App\Client');
    }
    public function executives(){
        return $this->belongsToMany('App\User','deal_executive','deal_id','executive_id');
    }
    public function contactPersons(){
        return $this->belongsToMany('App\Contact_person','deal_contact_person','deal_id','contact_person_id');
    }
    public function activities(){
        return $this->hasMany('App\Activity','id_of_linked_with')->where('linked_with',2);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function($row)
        {
            DB::table('deal_contact_person')->where('deal_id',$row->id)->delete();
            DB::table('deal_executive')->where('deal_id',$row->id)->delete();
            return true;
        });
    }

}
