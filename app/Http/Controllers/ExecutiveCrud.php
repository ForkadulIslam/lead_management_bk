<?php

namespace App\Http\Controllers;

use App\After_sale_member;
use App\Call_status;
use App\Invoice;
use App\Member;
use App\Next_payment_date;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Translation\Extractor\AbstractFileExtractor;

class ExecutiveCrud extends Controller
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
        $executives = User::where('roll_id',2)->paginate(10);
        return view('admin.modules.executive.index',compact('request','executives'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.modules.executive.create');
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
        $inputs['password'] = Hash::make($request->password);
        $inputs['roll_id'] = 2;
        $inputs['status'] = 1;
        User::create($inputs);
        return redirect()->back()->with('message','Registration Successful');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::find($id);
        return view('admin.modules.executive.edit',compact('data'));
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
        User::find($id)->fill($request->all())->save();
        return redirect('module/executive')->with('message','Executive updated..');
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
    public function member_details(Request $request,$member_id){
        $member = After_sale_member::find($member_id);
        $call_status = Call_status::where('member_id',$member_id)->orderBy('id','desc')->paginate(5);
        $invoices = Invoice::where('member_id',$member_id)->orderBy('id','desc')->paginate(5);
        //return $member->invoices->;
        return view('admin.modules.executive.member_details',compact('member','call_status','request','invoices'));
    }
    public function update_call_status(Request $request,$member_id){
        $member = After_sale_member::find($member_id);
        if($request->call_type  == 0){
            $input['call_type'] = 0;
            $input['status'] = $request->service_call_status;
            $input['remarks'] = $request->remarks;
            $input['member_id'] = $member_id;
            $member->fill(['services_call_status'=>$request->service_call_status])->save();
        }else{
            $input['call_type'] = 1;
            $input['status'] = $request->payment_call_status;
            $input['member_id'] = $member_id;
            $member->fill(['payment_call_status'=>$request->payment_call_status])->save();
        }
        $input['executive_id'] = Auth::user()->id;
        Call_status::create($input);
    }
    public function filter_call_history(Request $request,$member_id){
        $member = After_sale_member::find($member_id);
        $call_status = Call_status::where('member_id',$member_id)->where('call_type',$request->call_status)->orderBy('id','desc')->paginate(5);
        $invoices = Invoice::where('member_id',$member_id)->orderBy('id','desc')->paginate(5);
        return view('admin.modules.executive.member_details',compact('member','call_status','request','invoices'));
    }
    public function invoice_search(Request $request,$member_id){
        $member = After_sale_member::find($member_id);
        $call_status = Call_status::where('member_id',$member_id)->orderBy('id','desc')->paginate(5);
        $invoices = Invoice::where('member_id',$member_id)->orderBy('id','desc')->whereBetween('floating_payment_date',[$request->from,$request->to])->paginate(5);
        //return $invoices;
        return view('admin.modules.executive.member_details',compact('member','call_status','request','invoices'));
    }
    public function collector_allocation(Request $request){
        After_sale_member::find($request->member_id)->fill(['collector_id'=>$request->collector_id])->save();
        return redirect()->back()->with('message','Collector allocation successful');
    }
    public function save_payment_date(Request $request){
        Next_payment_date::create([
            'invoice_id'=>$request->invoice_id,
            'member_id'=>$request->member_id,
            'date'=>$request->date,
            'issued_by'=>Auth::user()->id,
        ]);
        return redirect()->back()->with('message','Payment date created');
    }
    public function collection(Request $request){
        $member_ids = After_sale_member::where('executive_id',Auth::user()->id)->pluck('id');
        $invoices = Next_payment_date::whereIn('member_id',$member_ids)->paginate(10);
        //return $invoices;
        return view('admin.modules.executive.collection',compact('invoices','invoices','request'));
    }
    public function search_invoice(Request $request){
        //return $request->all();
        //return $invoice_ids;
        $member_ids = After_sale_member::where('executive_id',Auth::user()->id)->pluck('id');
        $invoices = Next_payment_date::whereIn('member_id',$member_ids)->whereBetween('date',[$request->from,$request->to]);
        if(isset($request->payment_status)){
            $invoices->where('status',$request->payment_status);
        }
        $invoices = $invoices->paginate(10);
        //return $invoices->total();
        return view('admin.modules.executive.collection',compact('invoices','invoices','request'));
        //return $invoice_ids;
    }
    public function call_history(Request $request){
        $members = [];
        return view('admin.modules.executive.call_history',compact('request','members'));
    }
    public function search_call_history(Request $request){
        if($request->call_type == 0){
            $members = Call_status::whereBetween('created_at',[$request->from.' 00:00:00',$request->to.' 23:59:59'])->where('executive_id',Auth::user()->id)->paginate(30);
            //return $members;
            return view('admin.modules.executive.call_history',compact('members','request'));
        }else{
            $member_ids = Call_status::whereBetween('created_at',[$request->from.' 00:00:00',$request->to.' 23:59:59'])->where('executive_id',Auth::user()->id)->groupBy('member_id')->pluck('member_id');
            $members = After_sale_member::whereNotIn('id',$member_ids)->where('executive_id',Auth::user()->id)->paginate(30);
            return view('admin.modules.executive.not_call_history',compact('members','request'));
        }
    }
}
