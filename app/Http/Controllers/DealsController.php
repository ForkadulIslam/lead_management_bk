<?php

namespace App\Http\Controllers;

use App\Client;
use App\Contact_person;
use App\Deal;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DealsController extends Controller
{
    public function __construct(){
        $this->middleware('RedirectIfNotAuthenticate');
    }
    public function index(Request $request){
        $data = new Deal();
        $data = $data->with(['executives','contactPersons'])->orderBy('id','desc')->paginate(10);
        //return $data;
        return view('admin.modules.deals.index',compact('request','data'));
    }
    public function create(){
        return view('admin.modules.deals.create');
    }


    public function store(Request $request){
        //return $request->all();
        $deal = new Deal();
        $deal_input_data = $request->all();
        $deal_input_data['created_by'] = Auth::user()->id;
        $create = $deal->create($deal_input_data);
        $deal = $deal->find($create->id);
        if(isset($request->executive_ids)){
            $deal->executives()->attach($request->executive_ids);
        }
        if(isset($request->contact_person_ids)){
            $deal->contactPersons()->attach($request->contact_person_ids);
        }
        return redirect('module/deals')->with('message','New deals created');

    }
    public function show($id){
        $deal = Deal::find($id);
        $client =$deal->client;
        return view('admin.modules.deals.deal_details',compact('deal','client'));
    }
    public function edit($id){
        $deal = new Deal();
        $data = $deal->find($id);
        $assigned_executive_ids = [];
        foreach ($data->executives as $executive){
            $assigned_executive_ids[] = $executive->id;
        }
        $selected_contact_person_ids = [];
        $clients_all_contact_persons = $this->get_contact_person_by_client($data->client_id);
        foreach($data->contactPersons as $contactPerson){
            $selected_contact_person_ids[] = $contactPerson->id;
        }
        return view('admin.modules.deals.edit',compact('data','assigned_executive_ids','selected_contact_person_ids','clients_all_contact_persons'));
    }
    public function update(Request $request, $id){
        $deals = new Deal();
        $deal = $deals->find($id);
        $deal->fill($request->all())->save();
        $deal = $deals->find($id);
        $deal->executives()->sync(isset($request->executive_ids) ? $request->executive_ids : []);
        $deal->contactPersons()->sync(isset($request->contact_person_ids)? $request->contact_person_ids : []);
        return redirect('module/deals')->with('message','Deals updated');
    }
    public function get_contact_person_by_client($client_id){
        return Contact_person::where('client_id',$client_id)->get();
    }
    public function destroy($id){
        Deal::find($id)->delete();
    }
    public function search(Request $request){
        //return $request->all();
        $data= Deal::orderBy('creation_date','desc');
        if(!empty($request->client_name)){
            $clients = Client::select('id')->where('name','LIKE','%'.$request->client_name.'%')->get();
            $client_ids = [];
            foreach ($clients as $client){
                $client_ids[] = $client->id;
            }
            $data->whereIn('client_id',$client_ids);

        }
        if(!empty($request->stage)){
            $data->where('stage',$request->stage);
        }
        $executives = DB::table('deal_executive')->select('deal_id');
        if(!empty($request->executive_id)){
            $executives = $executives->where('executive_id',$request->executive_id);
        }
        $executives = $executives->get();
        $deal_ids = [];
        foreach ($executives as $executive){
            $deal_ids[] = $executive->deal_id;
        }
        $data = $data->whereIn('id',$deal_ids)->with(['executives','contactPersons'])->paginate(10);

        return view('admin.modules.deals.index',compact('request','data'));
    }
    public function deal_activity($deal_id,$activity_type){
        $deal = Deal::find($deal_id);
        $deal->activity_type = $activity_type;
        $client =$deal->client;
        //return $client->activities;
        return view('admin.modules.deals.activity_details',compact('client','deal'));
    }

}
