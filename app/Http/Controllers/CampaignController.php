<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Campaign_creative;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware('RedirectIfNotAuthenticate');
    }
    public function index()
    {

        $results = Campaign::orderBy('id','desc')->paginate(20);
        return view('admin.modules.campaign.index',compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.modules.campaign.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request->size;
        //return $this->make_dir_and_file(100,$request->size);
        $campaign = Campaign::create(request()->all());
        $creatives = [];
        foreach (request()->size as $i=>$item){
            $fileName = str_random(32).'.'.request()->file('creative_file')[$i]->extension();
            request()->file('creative_file')[$i]->move(public_path('uploads'), $fileName);
            $creatives[$i] = new Campaign_creative([
                'creative_title' => request()->creative_title[$i],
                'size'=>$item,
                'landing_url' => request()->landing_url[$i],
                'creative'=>$fileName
            ]);
        }
        $campaign->creatives()->saveMany($creatives);
        $this->make_dir_and_file($campaign->id);
        return redirect('module/campaign')->with('message','Campaign saved...');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $results = Campaign_creative::where('campaign_id',$id)->get();
        //return $results->first()->campaign->client_id;
        return view('admin.modules.campaign.creative_report',compact('results'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $campaign = Campaign::find($id);
        return view('admin.modules.campaign.edit',compact('campaign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        //return request()->all();
        $campaign = Campaign::find($id);
        $campaign->fill($request->all())->save();
        $creatives = [];
        if(!empty(request()->size)){
            foreach (request()->size as $i=>$item){
                $fileName = str_random(32).'.'.request()->file('creative_file')[$i]->extension();
                request()->file('creative_file')[$i]->move(public_path('uploads'), $fileName);
                $creatives[$i] = new Campaign_creative([
                    'creative_title' => request()->creative_title[$i],
                    'size'=>$item,
                    'landing_url' => request()->landing_url[$i],
                    'creative'=>$fileName
                ]);
            }
            $campaign->creatives()->saveMany($creatives);
            $this->make_dir_and_file($campaign->id);
        }
        return redirect('module/campaign')->with('message','Campaign updated...');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $campaign = Campaign::find($id);
        $campaign->creatives()->delete();
        $campaign->delete();
    }
    public function creative_report($creative_id){
        $creative = Campaign_creative::find($creative_id);
        //return $creative->campaign->client;
        return view('admin.modules.campaign.creative_report',compact('creative'));
    }
    public function creative_preview($creative_id){
        $creative = Campaign_creative::find($creative_id);
        //return $creative;
        return view('admin.modules.campaign.preview',compact('creative'));
    }

    public function make_dir_and_file($id){
        $creatives = Campaign::find($id)->creatives;
        foreach ($creatives as $creative){
            File::makeDirectory('html_contents/html/'.$id, $mode = 0777, true, true);
            File::put('html_contents/html/'.$id.'/'.$creative->size.'.html',view('admin.modules.campaign.preview',compact('creative')));
        }
    }
}



