<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contact_person extends Model
{
    protected $table = 'contact_persons';
    protected $fillable = ['name','email','phone','designation','department','client_id','created_by'];
    public function client(){
        return $this->belongsTo('App\Client');
    }
    public function created_by(){
        return $this->belongsTo('App\User','created_by');
    }
    public function creator(){
        return $this->belongsTo('App\User','created_by');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function($row)
        {
            DB::table('deal_contact_person')->where('contact_person_id',$row->id)->delete();
            DB::table('activity_contact_person')->where('contact_person_id',$row->id)->delete();
            return true;
        });
    }
}
