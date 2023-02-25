<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Duplicate_leads extends Model
{
    protected $fillable = ['id', 'file_name', 'name', 'phone', 'source', 'category'];
}
