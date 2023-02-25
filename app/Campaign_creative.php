<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign_creative extends Model
{
    protected $fillable = ['creative_title','size','landing_url','creative'];
    public function campaign(){
        return $this->belongsTo(Campaign::class,'campaign_id');
    }
}
