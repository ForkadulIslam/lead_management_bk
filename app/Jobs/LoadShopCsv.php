<?php

namespace App\Jobs;

use App\Date_wise_ad;
use App\Member;
use App\Shop_ad;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class LoadShopCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $url = null;
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $file = file($this->url);

        $data = array_slice($file, 1);
        $parts = (array_chunk($data, 1000));
        $i = 1;
        foreach($parts as $line) {
            $filename = base_path('resources/shop_csvs/'.date('y-m-d-H-i-s').$i.'.csv');
            file_put_contents($filename, $line);
            $i++;
        }
        $path = base_path("resources/shop_csvs/*.csv");
        foreach (array_slice(glob($path),0,count(glob($path))) as $file) {
            $items = array_map('str_getcsv', file($file));
            $items =  array_slice($items,0,1000);
            $arr_data = [];
            $j=0;
            foreach($items as $i=>$data){
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
            $csv_data=collect($arr_data);
            //return $csv_data;
            $shop_ids = collect($csv_data)->groupBy('shop_id')->keys();
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
            unlink($file);
        }
    }
}
