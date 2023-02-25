
<?php $__env->startSection('custom_page_style'); ?>
    <style>
        table td{
            vertical-align: middle!important;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-xs-12">
                    <h4>Live stats of ROBI Campaign - Started from 15 Oct 2020</h4>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-xs-4">
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
                <div class="col-xs-4">
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
                <div class="col-xs-4">
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
                                    <th class="text-left">Creative</th>
                                    <th>View</th>
                                    <th>Click</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="text-left">Welcome popup (Desktop)</td>
                                    <td><span id="desktop_popup_view_counter"></span></td>
                                    <td><span id="desktop_popup_click_counter"></span></td>
                                </tr>
                                <tr>
                                    <td class="text-left">Welcome popup (mWeb)</td>
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
                            <h2>BAR CHART</h2>
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
                            <canvas id="bar_chart" height="150"></canvas>
                        </div>
                    </div>
                </div>
                <!-- #END# Bar Chart -->
            </div>
        </div>

    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('custom_page_script'); ?>
    <!-- Custom Js -->
    <script src="<?php echo URL::to('public/plugins/chartjs/Chart.bundle.js'); ?>"></script>
    <script src="<?php echo URL::to('public/js/pages/charts/chartjs.js'); ?>"></script>
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
        let server_url = 'https://tracking.bikroyit.host';
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
                        campaign_id: 3,
                    }
                }
            );
            req.then(function(resp){
                let res = resp.data;
                let total_view = res[0];
                let total_click = res[1];
                //console.log(total_view)
                $('.view_counter').text(total_view);
                $('.click_counter').text(total_click);
                let ctr = (total_click/total_view)*100;
                $('.ctr_counter').text(ctr.toFixed(2));
                $('#desktop_popup_view_counter').text(res[2]);
                $('#desktop_popup_click_counter').text(res[3]);
                $('#mobile_popup_view_counter').text(res[4]);
                $('#mobile_popup_click_counter').text(res[5]);
                $('#970x250_view_counter').text(res[6]);
                $('#970x250_click_counter').text(res[7]);
                $('#970x90_view_counter').text(res[8]);
                $('#970x90_click_counter').text(res[9]);
                $('#320x250_view_counter').text(res[10]);
                $('#320x250_click_counter').text(res[11]);

                $('#320x100_view_counter').text(res[12]);
                $('#320x100_click_counter').text(res[13]);

                $('#300x250_view_counter').text(res[14]);
                $('#300x250_click_counter').text(res[15]);

                $('#160x600_view_counter').text(res[16]);
                $('#160x600_click_counter').text(res[17]);
            });
            req.catch(function(error){
                console.log(error);
            });
        }
        //update_stats()
        setInterval(update_stats,5000);

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>