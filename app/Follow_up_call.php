<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow_up_call extends Model
{
    protected $fillable = ['lead_id','queue_id', 'user_id', 'follow_up_date', 'remarks','status'];
    public function lead(){
        return $this->belongsTo(Lead::class);
    }
    public function calling_queue(){
        return $this->belongsTo(Calling_queue::class,'queue_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
