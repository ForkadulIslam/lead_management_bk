<?php


function menu_array(){
    return [

        [
            'label'=>'Agent',
            'roll_id'=>1,
            'icon'=>'perm_identity',
            'link'=>'#',
            'sub'=>[
                [
                    'label'=>'Create',
                    'link'=>URL::to('module/executive/create')
                ],
                [
                    'label'=>'List',
                    'link'=>URL::to('module/executive')
                ],
            ],
        ],
        [
            'label'=>'Manage Leads',
            'roll_id'=>1,
            'icon'=>'perm_identity',
            'link'=>'#',
            'sub'=>[
                [
                    'label'=>'Bucket',
                    'link'=>URL::to('module/lead/')
                ],
                [
                    'label'=>'Calling Queue',
                    'link'=>URL::to('module/calling_queue/create')
                ],
                [
                    'label'=>'Follow-up ',
                    'link'=>URL::to('module/calling_queue/follow_up')
                ],
            ],
        ],
        [
            'label'=>'Activity',
            'roll_id'=>1,
            'icon'=>'perm_identity',
            'link'=>URL::to('module/calling_queue'),
        ],

        /**=======EXECUTIVE MENU========**/
        [
            'label'=>'Manage Leads',
            'roll_id'=>2,
            'icon'=>'perm_identity',
            'link'=>'#',
            'sub'=>[
                [
                    'label'=>'Bucket',
                    'link'=>URL::to('module/lead/')
                ],
                [
                    'label'=>'Calling Queue',
                    'link'=>URL::to('module/calling_queue/create')
                ],
                [
                    'label'=>'Follow-up ',
                    'link'=>URL::to('module/calling_queue/follow_up')
                ],
            ],
        ],
        [
            'label'=>'Activity',
            'roll_id'=>2,
            'icon'=>'perm_identity',
            'link'=>URL::to('module/calling_queue'),
        ],
        



    ];
}
function generate_custom_image_path($path,$dimension){
    $path_arrs = explode('/',$path);
    $custom_path = '';
    foreach($path_arrs as $i=>$path_arr){
        if($i< count($path_arrs)-3){
            $custom_path.=$path_arr.'/';
        }
        if($i == count($path_arrs)-1){
            $custom_path .= $dimension.'/'.$path_arr;
        }
    }
    return $custom_path;
}
function generate_fitted_image($str){
    $explode = explode(',',$str);
    //return $explode;
    $img = explode(' ',trim($explode[1]))[0];
    $fitted_img = '';
    $img_path_arrays = explode('/',$img);
    foreach($img_path_arrays as $i=>$im){
        if($i < count($img_path_arrays)-1){
            $fitted_img .= $im.'/';
        }else{
            $fitted_img.='fitted.jpg';
        }
    }
    return $fitted_img;
}
function verticals(){
    return [
        'Mobiles'=>'Mobiles',
        'Electronics'=>'Electronics',
        'Home & Living'=>'Home & Living',
        'Property'=>'Property',
        'Vehicles'=>'Vehicles',
        'Fashion  Health & Beauty'=>'Fashion  Health & Beauty',
        'Education'=>'Education',
        'Hobbies  Sports & Kids'=>'Hobbies  Sports & Kids',
        'Services'=>'Services',
        'Jobs'=>'Jobs',
        'Pets & Animals'=>'Pets & Animals',
        'Food & Agriculture'=>'Food & Agriculture',
        'Business & Industry'=>'Business & Industry'
    ];
}
function services_call_status(){
    return [
        'Satisfied'=>'Satisfied',
        'Not Satisfied'=>'Not Satisfied',
        'Mobile OFF'=>'Mobile OFF',
        'Number Busy'=>'Number Busy',
        'No answer'=>'No answer',
    ];
}
function payment_call_status(){
    return [
        'Mobile OFF'=>'Mobile OFF',
        'No answer'=>'No answer',
        'Interested to pay'=>'Interested to pay',
        'Payment collected'=>'Payment collected',
        'Confirm Churn'=>'Confirm Churn',
        'Probable Churn'=>'Probable Churn',
    ];
}
function collector_payment_status(){
    return ['Collected'=>'Collected','Reschedule'=>'Reschedule','Churn'=>'Churn'];
}
function is_executive(){
    if(auth()->user()->roll_id === 2){
        return true;
    }else{
        return false;
    }
}
function upload_image($file){
    $extension = $file->getClientOriginalExtension();
    $rand = str_random();
    $file_name = $rand.'.'.$extension;
    $file->move('public/uploads/',$file_name);
    return $file_name;
}
function get_activity_list(){
    return ['Interested'=>'Interested','Not Interested'=>'Not Interested',
        'Informative'=>'Informative','Uncontactable'=>'Uncontactable',
        'Membership Sold'=>'Membership Sold','Switch Off'=>'Switch Off', 'No Answer'=>'No Answer', 'Others'=>'Others'];
}
function get_category(){
    return ['Mobiles'=>'Mobiles',
        'Mobile Phone Accessories'=> 'Mobile Phone Accessories',
        'Electronics'=>'Electronics', 'Motorbikes'=>'Motorbikes',
        'Cars'=>'Cars',
        'Bicycles & Three Wheelers'=>'Bicycles & Three Wheelers',
        'Auto Parts & Accessories' => 'Auto Parts & Accessories',
        'Auto Services' => 'Auto Services',
        'Trucks, Vans, Buses & Heavy Duty' =>'Trucks, Vans, Buses & Heavy Duty',
        'Water Transport' => 'Water Transport',
        'Properties for Sale' => 'Properties for Sale',
        'Properties for Rent' => 'Properties for Rent',
        'Home & Living' => 'Home & Living',
        'Pets & Animals' => 'Pets & Animals',
        'Fashion & Beauty' => 'Fashion & Beauty',
        'Hobbies, Sports & Kids' => 'Hobbies, Sports & Kids',
        'Education' => 'Education',
        'Business & Industry' => 'Business & Industry',
        'Essentials'=>'Essentials',
        'Services' => 'Services',
        'Agriculture' => 'Agriculture',
        'Jobs' => 'Jobs',
        'Overseas Jobs' => 'Overseas Jobs'
    ];
}
function membership_duration(){
    return [
        'Monthly' => 'Monthly',
        'Quarterly' => 'Quarterly',
        'Half Yearly' => 'Half Yearly',
        'Yearly' => 'Yearly'
    ];
}
function package_type(){
    return [
        'Business Plus' => 'Business Plus',
        'Business Premium' =>'Business Premium'
    ];
}
function membership_location(){
    return [
        'Dhaka' => 'Dhaka',
        'Chittagong' => 'Chittagong',
        'Rest' => 'Rest'
    ];
}
function get_activity_status(){
    return [1=>'Pending',2=>'Done',3=>'Canceled'];
}
function get_linked_with_list(){
    return [1=>'Client',2=>'Deals',3=>'Individual'];
}
function get_deals_stage(){
    return ['Prospect stage'=>'Prospect stage','Proposal made'=>'Proposal made','Negotiation'=>'Negotiation','Pending Sales'=>'Pending Sales','Won'=>'Won','Lost'=>'Lost'];
}