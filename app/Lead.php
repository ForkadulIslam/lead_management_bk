<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = ['id','name','phone','source','category'];
    public function calling_queue(){
        return $this->hasOne(Calling_queue::class);
    }
    public function follow_up(){
        return $this->hasMany(Follow_up_call::class);
    }
}
