<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Client;
use App\Contact_person;
use App\Deal;
use Illuminate\Http\Request;

class ActivityController extends Controller
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
        //dd(is_executive());
        $activities = Activity::orderBy('id','desc');
        if(is_executive()){
            $activities->where('executive_id',auth()->user()->id);
        }
        $data = $activities->paginate(10);
        //return $data;
        return view('admin.modules.activity.index',compact('request','data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.modules.activity.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request->all();
        $activities = new Activity();
        $inputs = $request->all();
        //return $inputs;
        $inputs['executive_id'] = auth()->user()->id;
        $activity = $activities->create($inputs);
        $activities->find($activity->id)->contact_persons()->attach(isset($request->contact_person_ids) ? $request->contact_person_ids : []);
        return redirect('module/activity')->with('message','Activity created..');
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
        $activities = new Activity();
        $data = $activities->find($id);
        if($data->linked_with == 1){
            $data['name_of_activity_with'] = isset($data->client->name) ? $data->client->name : 'N/A';
        }else if($data->linked_with == 2){
            $data['name_of_activity_with'] = isset($data->deal->title) ? $data->deal->title : 'N/A';
        }else{
            $data['name_of_activity_with'] = isset($data->individual_contact_person->name) ? $data->individual_contact_person->name : 'N/A';
        }
        //return $data->contact_persons;
        return view('admin.modules.activity.edit',compact('data'));
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
        $activities = new Activity();
        $activity = $activities->find($id);
        $activity->fill($request->all())->save();
        $activity->contact_persons()->sync(isset($request->contact_person_ids) ? $request->contact_person_ids : []);
        return redirect('module/activity')->with('message','Activity updated..');
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
    public function get_link_with_suggestion(Request $request, $linked_with){
        if($linked_with == 1){
            $data = Client::where('name','LIKE','%'.$request->q.'%')->select('id','name')->get();
            $data->each(function($item){
                $item->value = $item->id;
                $item->text = $item->name;
                unset($item->id,$item->name);
            });
            return $data->toArray();
        }
        if($linked_with == 2){
            $data = Deal::where('title','LIKE','%'.$request->q.'%')->select('id','title')->get();
            $data->each(function($item){
                $item->value = $item->id;
                $item->text = $item->title;
                unset($item->id,$item->title);
            });
            return $data->toArray();
        }
        if($linked_with == 3){
            $data = Contact_person::where('name','LIKE','%'.$request->q.'%')->select('id','name')->get();
            $data->each(function($item){
                $item->value = $item->id;
                $item->text = $item->name;
                unset($item->id,$item->name);
            });
            return $data->toArray();
        }
    }
    public function get_details_of_linked_with($linked_with,$id){
        if($linked_with == 1){
            $data = new Client();
            return $data->with('contact_persons')->find($id);
        }
        if($linked_with == 2){
            $data = new Deal();
            return $data->with('contactPersons')->find($id);
        }
        if($linked_with == 3){
            $data = new Contact_person();
            return $data->find($id);
        }
    }
    public function search(Request $request){
        //return $request->all();
        $data = Activity::orderBy('start_time','desc');
        if(!empty($request->status)){
            $data->where('status',$request->status);
        }
        if(!empty($request->executive_id)){
            $data->where('executive_id',$request->executive_id);
        }
        if(!empty($request->activity)){
            $data->where('type_of_activity',$request->activity);
        }
        $from = $request->from.' 00:00:00';
        $to = $request->to.' 23:59:59';
        $data = $data->whereBetween('start_time',[$from,$to])->paginate(10);

        return view('admin.modules.activity.index',compact('request','data'));
    }
}
