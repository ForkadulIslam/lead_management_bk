<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = ['client_id','campaign_title','total_impression','total_budget','remarks'];
    public function creatives(){
        return $this->hasMany(Campaign_creative::class);
    }
    public function client(){
        return $this->belongsTo(Client::class,'client_id');
    }
}
