<?php

namespace App\Http\Controllers;

use App\Client;
use App\Category;
use App\Contact_person;
use App\Invoice;
use App\Next_payment_date;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Psy\Command\ClearCommand;

class ClientCrud extends Controller
{
    public function __construct(){
        $this->middleware('RedirectIfNotAuthenticate',['except'=>['download_client']]);
    }

    public function index(Request $request)
    {
        //return 'test';
        $executives = User::where('roll_id',2)->get();
        $clients = Client::with(['contact_persons'])->orderBy('name','asc')->paginate(30);
        return view('admin.modules.client.index',compact('request','clients','executives'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.modules.client.create');
    }
    public function get_contact_person(Request $request){
        $contact_persons = Contact_person::where('name','LIKE','%'.$request->q.'%')->select('id','name','department')->get();
        $contact_persons->each(function($item){
            $item->value = $item->id;
            $item->text = $item->name.' <span class="font-12 .font-italic"> - '.$item->department.'</span>';
            unset($item->id,$item->name);
        });
        return $contact_persons->toArray();
    }
    public function contact_person_list(Request $request){
        $contact_persons = Contact_person::orderBy('name','asc')->paginate(20);
        return view('admin.modules.client.contact_person_list',compact('request','contact_persons'));
    }
    public function edit_contact_person($id){
        $contact_person = Contact_person::find($id);
        return view('admin.modules.client.edit_contact_person',compact('contact_person'));
    }
    public function contact_person_details($id){
        $contact_person = Contact_person::find($id);
        $client = $contact_person->client;
        //return $contact_person->client;
        return view('admin.modules.client.contact_person_details',compact('contact_person','client'));
    }
    public function update_contact_person(Request $request,$id){
        Contact_person::find($id)->fill($request->all())->save();
        return redirect(URL::to('module/client/contact_person_list'))->with('message','Contact person updated..');
    }
    public function search_contact_person(Request $request){
        $contact_persons = Contact_person::orderBy('name','asc');
        if(!empty($request->name)){
            $contact_persons->where(function($query) use($request){
                $query->where('name','LIKE','%'.$request->name.'%');
            });
        }
        $contact_persons = $contact_persons->paginate(30);
        return view('admin.modules.client.contact_person_list',compact('request','contact_persons'));
    }
    public function get_contact_person_details($id){
        return Contact_person::find($id);
    }
    public function delete_contact_person($contact_person_id){
        Contact_person::find($contact_person_id)->delete();
    }
    public function get_clients(Request $request){
        $data = Client::where('name','LIKE','%'.$request->q.'%')->select('id','name','industry')->get();
        $data->each(function($item){
            $item->value = $item->id;
            $item->text = $item->name;
            unset($item->id,$item->name);
        });
        return $data->toArray();
    }
    public function check_existing_client(Request $request){
        if(Client::where('name',$request->name)->first()){
            return 0;
        }else{
            return 1;
        }
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
        $client_input_data = [
            'created_by'=>Auth::user()->id,
            'name'=>$request->name,
            'address'=>$request->address,
            'industry'=>$request->industry,
        ];
        if($request->hasFile('file')){
            $client_input_data['logo'] = upload_image($request->file('file'));
        }
        $client = Client::create($client_input_data);
        $client = $client->find($client->id);
        $client->owner()->attach($request->executive_ids);
        if(isset($request->c_id)){
            foreach($request->c_id as $i=>$id){
                Contact_person::create([
                    'name'=>$request->c_name[$i],
                    'designation'=>$request->c_designation[$i],
                    'department'=>$request->c_department[$i],
                    'phone'=>$request->c_phone[$i],
                    'email'=>$request->c_email[$i],
                    'client_id'=>$client->id,
                    'created_by'=>Auth::user()->id,
                ]);
            }
        }
        return redirect('module/client')->with('message','Client created..');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::find($id);
        //return $client->deals;
        return view('admin.modules.client.client_details',compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Client::with(['contact_persons','contact_persons.created_by'])->find($id);
        $executive_ids = [];
        foreach ($client->owner as $executive){
            $executive_ids[] = $executive->id;
        }
        return view('admin.modules.client.edit',compact('client','executive_ids'));
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
        //return $request->all();
        $client_id = $id;
        $client = new Client();
        $client_input_data = [
            'name'=>$request->name,
            'address'=>$request->address,
            'industry'=>$request->industry,
        ];
        if($request->hasFile('file')){
            unlink('public/uploads/'.$client->logo);
            $client_input_data['logo'] = upload_image($request->file('file'));
        }
        $client->find($id)->fill($client_input_data)->save();
        //return $client->contact_persons;
        $client->find($id)->owner()->sync($request->executive_ids);
        if(isset($request->c_id)){
            foreach($request->c_id as $i=>$id){
                if($id>0){
                    Contact_person::find($id)->fill(['client_id'=>$client_id])->save();
                }else{
                    Contact_person::create([
                        'name'=>$request->c_name[$i],
                        'designation'=>$request->c_designation[$i],
                        'department'=>$request->c_department[$i],
                        'phone'=>$request->c_phone[$i],
                        'email'=>$request->c_email[$i],
                        'client_id'=>$client_id,
                        'created_by'=>Auth::user()->id,
                    ]);
                }
            }
        }
        return redirect('module/client')->with('message','Client updated..');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        //
    }
    public function search(Request $request){
        //return $request->all();
        $clients = Client::orderBy('name','asc');
        if(!empty($request->name)){
            $clients->where(function($query) use($request){
                $query->where('name','LIKE','%'.$request->name.'%');
            });
        }
        if(!empty($request->executive_ids)){
            $executives = DB::table('client_executive')->select('client_id')->whereIn('executive_id',$request->executive_ids)->get();
            $client_ids = [];
            foreach ($executives as $executive){
                $client_ids[] = $executive->client_id;
            }
            $clients->whereIn('id',$client_ids);
        }
        $clients = $clients->paginate(30);
        $executives = User::where('roll_id',2)->get();
        $executives = $executives->pluck('full_name','id');
        return view('admin.modules.client.index',compact('request','clients','executives'));
    }

    public function client_activity($client_id,$activity_type){
        $client = Client::find($client_id);
        $client->activity_type = $activity_type;
        //return $client->activities;
        return view('admin.modules.client.activity_details',compact('client'));
    }
    public function download_client(){
        //return 'test';
        $data = [];
        $contact_persons = Contact_person::get();
        //return $contact_persons;
        $index = 0;
        foreach ($contact_persons as $contact_person){
            $data[$index]['client_name'] = $contact_person->client ? $contact_person->client->name : '';
            $data[$index]['contact_person_name'] = $contact_person->name;
            $data[$index]['contact_person_phone'] = $contact_person->phone;
            $data[$index]['contact_person_email'] = $contact_person->email;
            $index++;
        }

        $fileName = 'client_list.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        //return $data;
        $columns = array('Client Name', 'Contact Person Name', 'Phone', 'Email');
        //return $columns;
        $callback = function() use($data, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            $row = [];
            foreach ($data as $result) {
                $row['client_name']  = $result['client_name'];
                $row['contact_person_name']    = $result['contact_person_name'];
                $row['contact_person_phone']    = $result['contact_person_phone'];
                $row['contact_person_email']    = $result['contact_person_email'];
                fputcsv($file, array($row['client_name'], $row['contact_person_name'], $row['contact_person_phone'],
                    $row['contact_person_email']));
            }
            fclose($file);
            //die($row);
        };
        return response()->stream($callback, 200, $headers);
    }



}

