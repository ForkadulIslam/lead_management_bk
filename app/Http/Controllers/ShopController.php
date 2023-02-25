<?php

namespace App\Http\Controllers;

use App\Date_wise_ad;
use App\Jobs\LoadShopCsv;
use App\Member;
use App\Shop;
use App\Shop_ad;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function __construct(){
        $this->middleware('RedirectIfNotAuthenticate',['except'=>['demo_link']]);
    }
    public function lists(Request $request){
        $members = Member::paginate(30);
        //return $members->first()->shop_ads->where('status',1);
        return view('admin.modules.shop_status.index',compact('members','request'));
    }
    public function create(){
        return view('admin.modules.shop_status.create');
    }
    public function post(Request $request){
        ini_set('memory_limit', '1000M');
        $path = $request->file('file')->getRealPath();
        $csv_data = array_map('str_getcsv', file($path));
        $arr_data = [];
        $j=0;
        foreach($csv_data as $i=>$data){
            if($i>0){
                if(isset($data[0]) && $data[0] !== 'NA'){
                    $arr_data[$j]['shop_id'] = isset($data[0]) ? $data[0] : null;
                    $arr_data[$j]['shop_name'] = isset($data[1]) ? $data[1] : null;
                    $arr_data[$j]['shop_profile_image'] = isset($data[2]) ? $data[2] : null;
                    $arr_data[$j]['shop_url'] = isset($data[3]) ? $data[3] : null;
                    $arr_data[$j]['ad_url'] = isset($data[4]) ? $data[4] :null;
                    $arr_data[$j]['ad_id'] = isset($data[5]) ? $data[5] : null;
                    $arr_data[$j]['l_one_category'] = isset($data[6]) ? $data[6] : null;
                    $arr_data[$j]['l_two_category'] = isset($data[7]) ? $data[7] : null;
                    $arr_data[$j]['ibs'] = isset($data[8]) ? $data[8]: null;
                    $arr_data[$j]['published_date'] = isset($data[9]) ? Carbon::parse($data[9])->format('Y-m-d h:m:s') :Carbon::now()->toDateTimeString();
                    $j++;
                }
            }
        }
        $csv_data=collect($arr_data);
        $shop_ids = collect($csv_data)->groupBy('shop_id')->keys();
        //ini_set('max_execution_time', 9000); //9000 seconds = 150 minutes
        //return $shop_ids;
        foreach($shop_ids as $shop_id){
            $shop = $csv_data->where('shop_id',$shop_id)->first();
            $member = Member::where('shop_id',$shop_id)->first();
            if(!$member){
                Member::create([
                    'shop_id'=>$shop_id,
                    'shop_name'=>$shop['shop_name'],
                    'shop_profile_image'=>$shop['shop_profile_image'],
                    'shop_url'=>$shop['shop_url'],
                ]);
            }
            $ads = $csv_data->where('shop_id',$shop_id);
            $ad_ids = [];
            $shop_insert_data = [];
            $index = 0;
            foreach($ads as $ad){
                $ad_ids[] = $ad['ad_id'];
                $existing_ad = Shop_ad::where('ad_id',$ad['ad_id'])->first();
                if($existing_ad){
                    $existing_ad->fill($ad)->save();
                }else{
                    $shop_insert_data[$index]['shop_id'] = $shop_id;
                    $shop_insert_data[$index]['ad_id'] = $ad['ad_id'];
                    $shop_insert_data[$index]['l_one_category'] = $ad['l_one_category'];
                    $shop_insert_data[$index]['l_two_category'] = $ad['l_two_category'];
                    $shop_insert_data[$index]['ibs'] = $ad['ibs'];
                    $shop_insert_data[$index]['ad_url'] = $ad['ad_url'];
                    $shop_insert_data[$index]['published_date'] = $ad['published_date'];
                    $index++;
                }
                $today = Carbon::now()->toDateString();
                if(!Date_wise_ad::where('date',$today)->where('ad_id',$ad['ad_id'])->first()){
                    $data_wize_ad_data = $ad;
                    $data_wize_ad_data['date'] = $today;
                    Date_wise_ad::create($data_wize_ad_data);
                }

            }
            Shop_ad::insert($shop_insert_data);
            Shop_ad::where('shop_id',$shop_id)->whereNotIn('ad_id',$ad_ids)->update(['status'=>'0']);
            $member = Member::where('shop_id',$shop_id)->first();
            $member_ads = $member->shop_ads;
            $total_live_ads = $member_ads->count();
            $total_ibs = $member_ads->sum('ibs');
            $avg_response = round($total_ibs/$total_live_ads);
            $member->fill([
                'total_live_ads'=>$total_live_ads,
                'total_ibs'=>$total_ibs,
                'avg_response'=>$avg_response,
            ])->save();
        }
        return redirect()->back()->with('message','Database updated');
    }
    public function report(){
        $members = Member::first();
        return $members->shop_ads;
    }
    public function search(Request $request){
        //return $request->all();
        $members = Member::select('shop_id','shop_name','shop_profile_image','shop_url','total_live_ads','total_ibs','avg_response');
        if(!empty($request->shop_id)){
            $members->where('shop_id',$request->shop_id);
        }
        if(!empty($request->vertical)){
            $shop_ids = Shop_ad::select('shop_id')->where('l_one_category',$request->vertical)->select('shop_id')->get();
            $shop_id_arr = [];
            foreach($shop_ids as $shop_id){
                $shop_id_arr[] = $shop_id->shop_id;
            }
            $members->whereIn('shop_id',$shop_id_arr);
        }
        if(!empty($request->short)){
            $short = explode(' ',$request->short);
            $members->orderBy($short[0],$short[1]);
        }
        $ads = explode(',',$request->ads);
        $ibs = explode(',',$request->ibs);
        $members->whereBetween('total_live_ads',$ads);
        $members->whereBetween('total_ibs',$ibs);
        $members = $members->paginate(30);

        //return $members->find(285);
        return view('admin.modules.shop_status.index',compact('members','request','ibs','ads'));
    }
    public function demo_link(){

        //ini_set("memory_limit", -1);
        $url = 'https://s3-eu-west-1.amazonaws.com/saltside-web-artifacts/production/remarketingv2/bikroy/online-remarketing-bikroy.csv';
        //$url = 'public/19 FEB AH2.csv';

        //$file = file($url);
        $items = array_map('str_getcsv', file($url));
        //$items =  array_slice($items,0,10000);
        $arr_data = [];
        $j=0;
        //return count($items);
        foreach($items as $i=>$data){
            if($i>0){
                if(isset($data[27]) && $data[27] !== 'NA'){
                    $arr_data[$j]['shop_id'] = isset($data[27]) ? $data[27] : null;
                    $arr_data[$j]['shop_name'] = isset($data[28]) ? $data[28] : null;
                    $arr_data[$j]['shop_profile_image'] = isset($data[3]) ? $data[3] : null;
                    $arr_data[$j]['shop_url'] = isset($data[7]) ? $data[7] : null;
                    $arr_data[$j]['ad_url'] = isset($data[8]) ? $data[8] :null;
                    $arr_data[$j]['ad_id'] = isset($data[0]) ? $data[0] : null;
                    $arr_data[$j]['ibs'] = isset($data[42]) ? $data[41]: null;
                    $arr_data[$j]['l_one_category'] = isset($data[19]) ? $data[19]: null;
                    $arr_data[$j]['l_two_category'] = isset($data[20]) ? $data[20]: null;
                    $arr_data[$j]['published_date'] = isset($data[25]) ? Carbon::parse($data[25])->format('Y-m-d h:m:s') :Carbon::now()->toDateTimeString();
                    $j++;
                    //return $arr_data;
                }
            }
        }
        $csv_data=collect($arr_data);
        $shop_ids = collect($csv_data)->groupBy('shop_id')->keys();
        foreach($shop_ids as $shop_id){
            //die('test');
            $shop = $csv_data->where('shop_id',$shop_id)->first();
            $member = Member::where('shop_id',$shop_id)->first();
            if(!$member){
                Member::create([
                    'shop_id'=>$shop_id,
                    'shop_name'=>$shop['shop_name'],
                    'shop_profile_image'=>$shop['shop_profile_image'],
                    'shop_url'=>$shop['shop_url'],
                ]);
            }
            $ads = $csv_data->where('shop_id',$shop_id);
            $ad_ids = [];
            $shop_insert_data = [];
            $data_wize_ad_data = [];
            $index = 0;
            $date_ad_index=0;
            foreach($ads as $ad){
                $ad_ids[] = $ad['ad_id'];
                $existing_ad = Shop_ad::where('ad_id',$ad['ad_id'])->first();
                if($existing_ad){
                    $existing_ad->fill($ad)->save();
                }else{
                    $shop_insert_data[$index]['shop_id'] = $shop_id;
                    $shop_insert_data[$index]['ad_id'] = $ad['ad_id'];
                    $shop_insert_data[$index]['ibs'] = $ad['ibs'];
                    $shop_insert_data[$index]['ad_url'] = $ad['ad_url'];
                    $shop_insert_data[$index]['l_one_category'] = $ad['l_one_category'];
                    $shop_insert_data[$index]['l_two_category'] = $ad['l_two_category'];
                    $shop_insert_data[$index]['published_date'] = $ad['published_date'];
                    $index++;
                }
                $today = Carbon::now()->toDateString();

                $data_wize_ad_data[$date_ad_index]['shop_id'] = $shop_id;
                $data_wize_ad_data[$date_ad_index]['ad_id'] = $ad['ad_id'];
                $data_wize_ad_data[$date_ad_index]['ibs'] = $ad['ibs'];
                $data_wize_ad_data[$date_ad_index]['date'] = $today;
                $date_ad_index++;

            }
            Shop_ad::insert($shop_insert_data);
            Shop_ad::where('shop_id',$shop_id)->whereNotIn('ad_id',$ad_ids)->update(['status'=>'0']);
            Date_wise_ad::insert($data_wize_ad_data);

            $member = Member::where('shop_id',$shop_id)->first();
            $member_ads = $member->shop_ads;
            $total_live_ads = $member_ads->count();
            $total_ibs = $member_ads->sum('ibs');
            $avg_response = round($total_ibs/$total_live_ads);
            $member->fill([
                'total_live_ads'=>$total_live_ads,
                'total_ibs'=>$total_ibs,
                'avg_response'=>$avg_response,
            ])->save();


        }

        return redirect()->back()->with('message','Database updated');
    }
    public function demo_post(Request $request){
        return $request->all();
        array_slice($argv,0,10);
    }
}
