<?php

namespace App\Http\Controllers;

use App\Calling_queue;
use App\Follow_up_call;
use App\Lead;
use App\Revenue_from_lead;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CallingQueue extends Controller
{
    public function __construct()
    {
        $this->middleware('RedirectIfNotAuthenticate');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $queue = Calling_queue::where('user_id',auth()->user()->id)->where('status',1)->orderBy('updated_at','desc')->paginate();

        return view('manage_lead.my_activity',compact('queue'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rows = Calling_queue::where('status',0)->where('created_at', '<', Carbon::now()->subMinutes(30))->get();
        $rows->each(function($row){
            $row->delete();
        });
        $queued_lead = Calling_queue::pluck('lead_id');
        $my_queued_lead = auth()->user()->active_leads()->pluck('lead_id');
        $leads = Lead::orderBy('id','desc')->whereNotIn('id',$queued_lead)->take(3-count($my_queued_lead))->get();
        $leads->each(function($item){
            Calling_queue::create([
                'user_id'=>auth()->user()->id,
                'lead_id'=>$item->id,
                'status'=>0
            ]);
        });
        $active_leads =  auth()->user()->active_leads()->with(['lead'])->get();
        $active_leads->each(function($item){
            $item->remaining_minutes = 0;
            $item->str_to_time = strtotime($item->created_at)*1000;
        });
        //return $active_leads;
        //return strtotime($active_leads->first()->created_at)*1000;
        return view('manage_lead.calling_queue',compact('active_leads'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        $queue = Calling_queue::find($inputs['queue_id']);
        if($queue){
            $calling_queue_data = [
                'user_id'=>auth()->user()->id,
                'status'=>1,
                'calling_status'=>$inputs['calling_status'],
                'status_sub_type'=>$request->status_sub_type,
                'remarks' => ($request->calling_status !== 'Uncontactable' || $request->calling_status !== 'Switch Off') ? $request->remarks : null
            ];
            $queue->fill($calling_queue_data)->save();
            if($request->calling_status === 'No Answer' || $request->calling_status === 'Switch Off' || $request->calling_status === 'Interested'){
                Follow_up_call::create([
                    'lead_id'=>$queue->lead_id,
                    'queue_id'=>$queue->id,
                    'user_id'=>auth()->user()->id,
                    'follow_up_date' => $request->follow_up_date,
                    'status' => 0,
                    'remarks' => $request->remarks,
                ]);
            }
            if($request->calling_status === 'Membership Sold'){
                Revenue_from_lead::create([
                    'lead_id'=> $queue->lead_id,
                    'user_id' => auth()->user()->id,
                    'membership_category' => $request->membership_category,
                    'membership_duration' => $request->membership_duration,
                    'package_type' => $request->package_type,
                    'membership_location' => $request->membership_location,
                    'revenue'=>$request->revenue,
                ]);
            }
            return redirect('module/calling_queue/create')->with('message','Queue Updated');
        }else{
            return redirect('module/calling_queue/create')->with('error_message','Your time has been expired for this lead');
        }
    }

    public function create_from_follow_up_queue(Request $request){
        $follow_up = Follow_up_call::find($request->follow_up_id);
        //return $follow_up;
        $follow_up->fill(['status'=>1])->save();
        $queue = Calling_queue::find($request->queue_id);
        if($queue){
            if($request->calling_status === 'No Answer' || $request->calling_status === 'Switch Off' || $request->calling_status === 'Interested'){
                $calling_queue_data = [
                    'user_id'=>auth()->user()->id,
                    'status'=>1,
                    'calling_status'=>$request->calling_status,
                    'status_sub_type'=>$request->status_sub_type,
                ];
                $queue->fill($calling_queue_data)->save();
                Follow_up_call::create([
                    'lead_id'=>$queue->lead_id,
                    'queue_id'=>$queue->id,
                    'user_id'=>auth()->user()->id,
                    'follow_up_date' => $request->follow_up_date,
                    'status' => 0,
                    'remarks' => $request->remarks,
                ]);
            }else if($request->calling_status === 'Membership Sold'){
                $calling_queue_data = [
                    'user_id'=>auth()->user()->id,
                    'status'=>1,
                    'calling_status'=>$request->calling_status,
                    'status_sub_type'=>$request->status_sub_type,
                    'remarks' => $request->remarks,
                ];
                $queue->fill($calling_queue_data)->save();
                Revenue_from_lead::create([
                    'lead_id'=> $queue->lead_id,
                    'user_id' => auth()->user()->id,
                    'membership_category' => $request->membership_category,
                    'membership_duration' => $request->membership_duration,
                    'package_type' => $request->package_type,
                    'membership_location' => $request->membership_location,
                    'revenue'=>$request->revenue,
                ]);
            }else{
                $calling_queue_data = [
                    'user_id'=>auth()->user()->id,
                    'status'=>1,
                    'calling_status'=>$request->calling_status,
                    'status_sub_type'=>$request->status_sub_type,
                    'remarks' => $request->remarks,
                ];
                $queue->fill($calling_queue_data)->save();
            }
        }

        return redirect('module/calling_queue/follow_up')->with('message','Follow-up Updated');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function search(Request $request){
        $queue = Calling_queue::where('user_id',auth()->user()->id)->where('status',1)->orderBy('updated_at','desc');
        if(!empty($request->calling_status)){
            $queue->where('calling_status',$request->calling_status);
        }

        $from = $request->from.' 00:00:00';
        $to = $request->to.' 23:59:59';
        $queue = $queue->whereBetween('updated_at',[$from,$to])->paginate(10);

        return view('manage_lead.my_activity',compact('queue'));
    }
    public function get_follow_up(){
        $from = Carbon::now()->toDateString();
        $to = Carbon::now()->toDateString();
        $follow_ups =  Follow_up_call::with(['lead'])->where('status',0)->where('user_id',auth()->user()->id)->whereBetween('follow_up_date',[$from,$to])->get();
        return $follow_ups;
        return view('manage_lead.my_follow_up',compact('follow_ups'));
    }
    public function search_follow_up(Request $request){
        $from = $request->from;
        $to = $request->to;
        $follow_ups =  Follow_up_call::with(['lead','calling_queue'])->where('status',0)->where('user_id',auth()->user()->id)->whereBetween('follow_up_date',[$from,$to]);

        if($request->status){
            $calling_status_wise_id = Calling_queue::where('user_id',auth()->user()->id)->where('calling_status',$request->status)->pluck('id');
            $follow_ups->whereIn('id',$calling_status_wise_id);
        }


        $follow_ups =  $follow_ups->get();
        //return $follow_ups;
        return view('manage_lead.my_follow_up',compact('follow_ups'));
    }
}
