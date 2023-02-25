<?php $__env->startSection('custom_page_style'); ?>
    <style>
        table td{
            vertical-align: middle!important;
        }
        .live_campaign_indicator{
            position: absolute;
            top: 16px;
            right: 2px;
            width: 30px;
        }
        .live_campaign_indicator{
            display: none;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="block-header">
            <a href="<?php echo URL::to('admin'); ?>">
                <strong>Campaign lists</strong>
            </a>
            <?php if(Session::has('message')): ?>
                <div class="alert bg-teal alert-dismissible m-t-20 animated fadeInDownBig" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <?php echo Session::get('message'); ?>

                </div>
            <?php endif; ?>
        </div>

        <!-- Striped Rows -->
        <div class="row clearfix" id="app">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <p>List of campaign</p>
                    </div>
                    <div class="body table-responsive">
                        <?php echo Form::open(['url'=>URL::to('module/member/table_action'),'id'=>'table_form']); ?>

                        <p>TOTAL CAMPAIGN: <?php echo $results->total();; ?></p>
                        <table class="table table-striped table-bordered table-hover table-responsive">
                            <thead>
                            <tr>
                                <th style="width:250px;">Title</th>
                                <th style="width: 115px">Client</th>
                                <th style="width: 100px">Created at</th>
                                <th>Total Impression</th>
                                <th>Budget</th>
                                <th>Impression Delivered</th>
                                <th>Click count</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="font-12" data-row_id="<?php echo $item->id; ?>">
                                    <td style="width:250px; position: relative">
                                        <a href="<?php echo URL::to('module/campaign',$item->id); ?>" data-toggle="tooltip" data-title="View details"><?php echo $item->campaign_title; ?></a>
                                        <p><small><strong><?php echo \Carbon\Carbon::parse($item->created_at)->diffForHumans(); ?></strong></small></p>
                                        <img class="live_campaign_indicator" src="<?php echo asset('public/images/live.gif'); ?>" alt="Live image icon">
                                    </td>
                                    <td>
                                        <?php echo $item->client->name; ?>

                                    </td>
                                    <td>
                                        <p class="margin-0"><?php echo $item->created_at->toDateString(); ?></p>
                                    </td>
                                    <td>
                                        <?php echo $item->total_impression; ?>

                                    </td>
                                    <td><?php echo $item->total_budget; ?></td>
                                    <td>
                                        <p class="impression_badge"></p>
                                    </td>
                                    <td>
                                        <span class="click_badge"></span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php echo Form::close(); ?>

                        <?php echo $results->appends(request()->except(['_token']))->links(); ?>

                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Striped Rows -->
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('custom_page_script'); ?>
    <!-- Custom Js -->

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
        let request_arr = [];
        let request_url = 'https://tracking.bikroyit.com:5500/analytics_by_id/';

        let get_analytics = function(){
            //$('.live_campaign_indicator').css('display','none');
            let client_id = 'Walton'
            $('table tbody tr').each(async function(item){
                let campaign_id = $(this).data('row_id');
                let response = await axios.get(request_url+client_id+'/'+campaign_id);
                let ctr = response.data[0] > 0 ? (response.data[1]/response.data[0])*100 : 0;
                $(this).find('.impression_badge').text(response.data[0].toLocaleString())
                $(this).find('.click_badge').text(response.data[1]);

                $(this).find('.ctr_badge').text(ctr.toFixed(2));
                if(response.data[2] === true){
                    $(this).find('.live_campaign_indicator').css('display','block');
                }else{
                    $(this).find('.live_campaign_indicator').css('display','none');
                }
            });

        }
        $(document).ready(function(){
            get_analytics();
            setInterval(function(){
                get_analytics();
            },5000);
        })

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>