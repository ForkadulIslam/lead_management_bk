<?php

namespace App\Http\Controllers;

use App\Duplicate_leads;
use App\Lead;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class LeadController extends Controller
{
    function __construct()
    {
        $this->middleware('RedirectIfNotAuthenticate',['except'=>[]]);
    }

    public function index(){

        $leads = Lead::orderBy('id','desc')->paginate(20);
        //return $leads;
        $leads->each(function($item){
            $total_attempts = $item->calling_queue()->where('status',1)->count();
            $total_attempts += $item->follow_up()->where('status',1)->count();
            $item->no_of_attempts = $total_attempts;
        });
        //return $leads;
        return view('manage_lead.index',compact('leads'));
    }
    public function store(Request $request){
        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
        $leads = new Lead();
        foreach($rows as $i=>$item){
            if($i>0){
                $data_to_be_inserted = [
                    'name'=>$item[3],
                    'phone'=>$item[4],
                    'category'=>$item[2],
                    'source'=>$item[1],
                ];
                $existingRecord = $leads->where('phone',$item[4])->where('category',$item[2])->first();
                if(!$existingRecord){
                    $leads->create($data_to_be_inserted);
                }else{
                    $data_to_be_inserted['file_name'] = $file->getClientOriginalName();
                    Duplicate_leads::create($data_to_be_inserted);
                }
            }
        }

    }

    public function create(){
        return view('manage_lead.create');
    }

    public function activity_details($lead_id){
        $lead = Lead::find($lead_id);
        return view('manage_lead.lead_activity',compact('lead'));
    }
}
