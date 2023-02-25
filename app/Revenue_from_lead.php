<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revenue_from_lead extends Model
{
    protected $fillable = ['lead_id','user_id','membership_category', 'membership_duration','package_type', 'membership_location', 'revenue'];
}
