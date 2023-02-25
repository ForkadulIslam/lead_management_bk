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
                    <h4>Live stats of Rupayon Campaign</h4>
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
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Creative wise breakdown</h2>
                        </div>
                        <div class="body">
                            <table class="table table-border table-hovered text-center">
                                <thead>
                                <tr class="">
                                    <td class="text-left">#</td>
                                    <td>View</td>
                                    <td>Click</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th class="text-left">Desktop</th>
                                    <td><span id="970x250_view_counter"></span></td>
                                    <td><span id="970x250_click_counter"></span></td>
                                </tr>
                                <tr>
                                    <th class="text-left">Mobile web</th>
                                    <td><span id="m_web_view_counter"></span></td>
                                    <td><span id="m_web_click_counter"></span></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('custom_page_script'); ?>

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
                        campaign_id: 1,
                        client_id:'Rupayon_roadblock'
                    }
                }
            );
            req.then(function(resp){
                let res = resp.data;
                let total_view = res[0]+26348+37897+3000+3000;
                let total_click = res[1]+150+150;
                //console.log(total_view)
                $('.view_counter').text(total_view);
                $('.click_counter').text(total_click);
                let ctr = (total_click/total_view)*100;
                $('.ctr_counter').text(ctr.toFixed(2));
                $('#970x250_view_counter').text(res[2]+26348+3000);
                $('#970x250_click_counter').text(res[3]+150);
                $('#m_web_view_counter').text(res[4]+37897+3000);
                $('#m_web_click_counter').text(res[5]+150);
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