<?php

namespace App\Http\Controllers;

use App\Activity;

use App\Calling_queue;
use App\Campaign;
use App\Deal;
use App\Lead;
use App\Mail\DailyActivity;
use App\Mail\DailySummary;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class Admin extends Controller{
    public function __construct(){
        $this->middleware('RedirectIfNotAuthenticate',['except'=>['send_daily_summary','send_daily_activity','client_wise_summary']]);
    }
    public function index(){
        $dashboard = 'admin.index';
        $executives_ids =  Calling_queue::whereBetween('updated_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])->select('user_id')->groupBy('user_id')->get();
        $executives_ids =  $executives_ids->pluck('user_id')->toArray();
        $executives =  User::whereIn('id',$executives_ids)->get();
        //return $executives;
        $total_leads = Lead::count();
        $queue_leads = Calling_queue::where('status',0)->count();
        return view($dashboard,compact('executives','total_leads','queue_leads'));
    }
    public function send_daily_activity(){

//        $to      = 'forkadulislam@gmail.com';
//        $subject = 'the subject';
//        $message = 'hello';
//        $headers = 'From: webmaster@example.com' . "\r\n" .
//            'Reply-To: webmaster@example.com' . "\r\n" .
//            'X-Mailer: PHP/' . phpversion();
//
//        $check = mail($to, $subject, $message, $headers);
//        dd($check);


        $executives = User::where('roll_id',2)->get();
        //return $executives;
        $from =  Carbon::now()->toDateString().' 00:00:00';
        $to =  Carbon::now()->toDateString().' 23:59:59';
        foreach($executives as $executive){
            //return $executive->email;
            $upcoming_activity = Activity::with(['contact_persons'])
                ->where('executive_id',$executive->id)
                ->whereBetween('start_time',[$from,$to])
                ->orderBy('start_time','desc')
                ->get();
            $name = $executive->full_name;
            $content =  view('email.daily_activity',compact('name','upcoming_activity'));
            $target_url = 'https://outsource.bikroyit.com/user/activity.php'; // Write your URL here
            $post_data = array('subject'=> 'Daily Activity', 'message_body'=>$content, 'to'=>$executive->email); // Parameter to be sent
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $target_url);
            curl_setopt($ch, CURLOPT_POST,1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result =   curl_exec($ch);
            curl_close ($ch);
            //return 'Activity email was sent';

        }
        //return $executives;
        return 'Daily activity was sent';
    }
    public function send_daily_summary(){
        //return $executives;
        $from =  Carbon::now()->toDateString().' 00:00:00';
        $to =  Carbon::now()->toDateString().' 23:59:59';
        $activities = Activity::with(['client','deal','individual_contact_person'])->whereBetween('start_time',[$from,$to])
            ->orderBy('start_time','desc')
            ->get();
        $activities = $activities->groupBy('executive_id');
        //return $activities;
        $content =  view('email.daily_summary',compact('activities'));

        $target_url = 'https://outsource.bikroyit.com/user/activity.php'; // Write your URL here
        $post_data = array('subject'=> 'Activity Summary', 'message_body'=>$content, 'to'=>'sanjoy.biswas@bikroy.com,eshita@bikroy.com'); // Parameter to be sent


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $target_url);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result =   curl_exec($ch);
        curl_close ($ch);
        return 'Activity email was sent';
    }

    public function client_wise_summary(){
        $from =  Carbon::now()->startOfMonth();
        $to =  Carbon::now()->endOfWeek();
        $activities = Activity::whereBetween('start_time',[$from,$to])
            ->orderBy('start_time','desc')
            ->get();
        $activities->each(function($item){
            $client_id = '';
            if($item->linked_with == 1){
                $client_id = $item->client['id'];
            }
            if($item->linked_with == 2){
                $client_id = $item->deal['client_id'];
                $item->client = $item->deal->client;
                unset($item->deal);
            }
            
            $item->client_id = $client_id;
        });
        $activities =  $activities->groupBy('client_id');
        //return $activities;
        $content =  view('email.client_wise_activity_summary',compact('activities'));
        //return $content;
        $target_url = 'https://outsource.bikroyit.com/user/activity.php'; // Write your URL here
        $post_data = array('subject'=> 'Client Wise Activity Summary', 'message_body'=>$content, 'to'=>'sanjoy.biswas@bikroy.com,eshita@bikroy.com'); // Parameter to be sent
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $target_url);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result =   curl_exec($ch);
        curl_close ($ch);
        return 'Activity email was sent';

    }




}
