@extends('admin.layouts.form')
@section('custom_page_style')
    <style>
        table td{
            vertical-align: middle!important;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-xs-12">
                    <h4>Live stats of VIVO Campaign.</h4>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-xs-3">
                    <div class="info-box bg-pink hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">remove_red_eye</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL VIEW</div>
                            <div class="number count-to view_counter" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20">0</div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class="info-box bg-deep-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">mouse</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL CLICK</div>
                            <div class="number count-to click_counter" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20">0</div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class="info-box bg-light-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">show_chart</i>
                        </div>
                        <div class="content">
                            <div class="text">CTR</div>
                            <div class="number count-to ctr_counter" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20">0</div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class="info-box bg-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">filter_center_focus</i>
                        </div>
                        <div class="content">
                            <div class="text">LIVE VISITOR</div>
                            <div class="number live_user_counter count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <!-- Line Chart -->
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Creative wise breakdown</h2>
                        </div>
                        <div class="body">
                            <table class="table table-border table-hovered text-center">
                                <thead>
                                <tr class="">
                                    <td>#</td>
                                    <td>View</td>
                                    <td>Click</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th class="text-left">Welcome popup (Desktop)</th>
                                    <td><span id="desktop_popup_view_counter"></span></td>
                                    <td><span id="desktop_popup_click_counter"></span></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Welcome popup (mWeb)</th>
                                    <td><span id="mobile_popup_view_counter"></span></td>
                                    <td><span id="mobile_popup_click_counter"></span></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- #END# Line Chart -->
                <!-- Bar Chart -->
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Location wise user</h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <table class="table table-condensed font-12">
                                <thead>
                                <tr>
                                    <th>Division</th>
                                    <th>Impression</th>
                                    <th>Click</th>
                                    <th>CTR</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Barisal Division</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Chittagong Division</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Dhaka Division</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Khulna Division</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Mymensingh Division</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Rangpur Division</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Sylhet Division</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Rajshahi Division</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- #END# Bar Chart -->
            </div>
        </div>

    </div>

@endsection
@section('custom_page_script')
    <!-- Custom Js -->
    <script src="{!! URL::to('public/plugins/chartjs/Chart.bundle.js') !!}"></script>
    <script src="{!! URL::to('public/js/pages/charts/chartjs.js') !!}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.datepicker').bootstrapMaterialDatePicker({
                format: 'YYYY-MM-DD',
                clearButton: true,
                weekStart: 1,
                time: false
            });
        });
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.dev.js"></script>


    <script type="text/javascript">
        let server_url = 'https://tracking.bikroyit.com:5500';
        let socket = io(server_url);


        socket.on('connect', function(){

        });
        socket.on('updateLiveUserCounter',function(data){
            $('.live_user_counter').text(data);
        });

        function update_stats(){
            let req = axios.get(
                server_url+'/get_stats',
                {
                    params:{
                        campaign_type: '*',
                        campaign_id: 9,
                        client_id:'Vivo'
                    }
                }
            );
            req.then(function(resp){
                let res = resp.data;
                let total_view = res[0];
                let total_click = res[3]+res[5];
                //console.log(total_view)
                $('.view_counter').text(total_view);
                $('.click_counter').text(total_click);
                let ctr = (total_click/total_view)*100;
                $('.ctr_counter').text(ctr.toFixed(2));
                $('#desktop_popup_view_counter').text(res[2]);
                $('#desktop_popup_click_counter').text(res[3]);
                $('#mobile_popup_view_counter').text(res[4]);
                $('#mobile_popup_click_counter').text(res[5]);
                
            });
            req.catch(function(error){
                console.log(error);
            });
        }
        //update_stats()
        setInterval(update_stats,5000);

    </script>
@endsection