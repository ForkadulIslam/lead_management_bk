<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Calling_queue extends Model
{
    protected $table = 'calling_queues';
    protected $fillable = ['lead_id', 'user_id', 'status', 'calling_status', 'status_sub_type', 'follow_up_date', 'remarks'];
    public function lead(){
        return $this->belongsTo(Lead::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function handle()
    {
        $rows = Calling_queue::where('status',0)->where('created_at', '<', Carbon::now()->subMinutes(10))->get();
        foreach ($rows as $row) {
            $row->delete();
        }
    }
}
