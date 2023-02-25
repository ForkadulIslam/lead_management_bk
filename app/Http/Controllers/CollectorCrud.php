<?php

namespace App\Http\Controllers;

use App\After_sale_member;
use App\Invoice;
use App\Invoice_collection;
use App\Member;
use App\Next_payment_date;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CollectorCrud extends Controller
{
    public function __construct(){
        $this->middleware('RedirectIfNotAuthenticate');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $collectors = User::where('roll_id',3)->latest()->paginate(10);
        return view('admin.modules.collector.index',compact('collectors','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.modules.collector.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $path = $request->file('file')->getRealPath();
        $csv_data = array_map('str_getcsv', file($path));
        $arr_data = [];
        foreach ($csv_data as $i=>$data){
            if($i>0 && !empty($data[0])){
                $email = trim($data[1]);
                $arr_data = [
                    'full_name'=>$data[0],
                    'email'=>$email,
                    'phone'=>$data[2],
                    'roll_id'=>3,
                    'password'=>Hash::make('123456'),
                ];
                $collector = User::where('email',$email)->first();
                if(!$collector){
                    User::create($arr_data);
                }else{
                    $collector->fill($arr_data)->save();
                }
            }
        }
        return redirect()->back()->with('message','Database updated');
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
    public function member(Request $request){
        $locations = After_sale_member::select('location')->where('collector_id',Auth::user()->id)->groupBy('location')->get();
        $members = After_sale_member::latest()->where('collector_id',Auth::user()->id)->paginate(10);
        return view('admin.modules.collector.member_list',compact('members','locations','request'));
    }
    public function search_member(Request $request){
        $locations = After_sale_member::select('location')->where('collector_id',Auth::user()->id)->groupBy('location')->get();
        $members = After_sale_member::select('*');
        if(!empty($request->name)){
            $members->where('name','LIKE','%'.$request->name.'%');
        }
        if(!empty($request->location)){
            $members->where('location',$request->location);
        }
        $members = $members->where('collector_id',Auth::user()->id)->paginate(10);
        return view('admin.modules.collector.member_list',compact('request','members','locations'));
    }
    public function member_details(Request $request,$member_id){
        $member = After_sale_member::find($member_id);
        $invoices = Invoice::where('member_id',$member_id)->orderBy('id','desc')->paginate(5);
        return view('admin.modules.collector.member_details',compact('member','invoices','request'));
    }
    public function collection(Request $request){
        $member_ids = After_sale_member::where('collector_id',Auth::user()->id)->pluck('id');
        $invoices = Next_payment_date::whereIn('member_id',$member_ids)->paginate(10);
        //return $invoices;
        return view('admin.modules.collector.collection',compact('invoices','invoices','request'));
    }
    public function save_collection(Request $request){
        //return $request->all();
        if($request->status == 'Collected'){
            Invoice_collection::create([
                'invoice_id'=>$request->invoice_id,
                'member_id'=>$request->member_id,
                'amount'=>$request->amount,
                'payment_method'=>$request->payment_method,
                'collected_by'=>Auth::user()->id,
            ]);
        }

        $payment_date  = Next_payment_date::find($request->id);
        if($payment_date){
            $remarks = $request->remarks;
            if($request->status =='Reschedule'){
                $remarks = $request->date;
            }
            $payment_date->fill([
                'status'=>$request->status,
                'collected_by'=>Auth::user()->id,
                'remarks'=>$remarks,
            ])->save();
        }
        return redirect()->back()->with('message','Collection created');
    }
    public function search_invoice(Request $request){
        //return $request->all();
        //return $invoice_ids;
        $member_ids = After_sale_member::where('collector_id',Auth::user()->id)->pluck('id');
        $invoices = Next_payment_date::whereIn('member_id',$member_ids)->whereBetween('date',[$request->from,$request->to]);
        if(isset($request->payment_status)){
            $invoices->where('status',$request->payment_status);
        }
        $invoices = $invoices->paginate(10);
        //return $invoices;
        return view('admin.modules.collector.collection',compact('invoices','invoices','request'));
        //return $invoice_ids;
    }
}
