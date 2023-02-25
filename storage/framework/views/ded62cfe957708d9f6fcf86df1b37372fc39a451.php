
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
            <a href="<?php echo URL::to('module/campaign'); ?>">
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
                        <a href="<?php echo URL::to('module/campaign/create'); ?>" class="btn btn-xs btn-primary"> <i class="material-icons">add_circle_outline</i> Create new campaign</a>
                    </div>
                    <div class="body table-responsive">
                        <?php echo Form::open(['url'=>URL::to('module/campaign/search'),'method'=>'post']); ?>

                        <?php echo Form::close(); ?>

                        <?php echo Form::open(['url'=>URL::to('module/member/table_action'),'id'=>'table_form']); ?>

                        <p>TOTAL CAMPAIGN: <?php echo $results->total();; ?></p>
                        <table class="table table-striped table-bordered table-hover table-responsive">
                            <thead>
                            <tr>
                                <th style="width:250px;">Title</th>
                                <th style="width: 115px">Client</th>
                                <th style="width: 100px">Created at</th>
                                <th>Max <br> Impression</th>
                                <th style="width: 104px">Total <br> Budget</th>
                                <th style="width: 104px">Budget <br> Spent</th>
                                <th>Impression Delivered</th>
                                <th>Click count</th>
                                <th style="width:100px;">Option</th>
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
                                    <?php echo isset($item->client->name) ? $item->client->name : 'N/A'; ?>

                                </td>
                                <td>
                                    <p class="margin-0"><?php echo $item->created_at->toDateString(); ?></p>
                                </td>
                                <td data-total_impression="<?php echo $item->total_impression; ?>">
                                    <?php echo $item->total_impression; ?>

                                </td>
                                <td><span data-total_budget="<?php echo $item->total_budget; ?>"><?php echo $item->total_budget; ?> TK</span></td>
                                <td><span class="budget_spent_badge">0</span></td>
                                <td>
                                    <p class="impression_badge"></p>
                                </td>
                                <td>
                                    <span class="click_badge"></span>
                                </td>
                                <td style="width:100px;">
                                    <a data-toggle="tooltip" data-title="Edit" class="btn btn-xs btn-warning" href="<?php echo URL::to('module/campaign/'.$item->id,'edit'); ?>"><i class="material-icons">edit</i></a>
                                    <a data-toggle="tooltip" data-title="Delete" class="btn btn-xs btn-danger delete_with_swal" href="<?php echo URL::to('module/campaign',$item->id); ?>"><i class="material-icons">remove</i></a>
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
    <script type="text/javascript">
        let request_arr = [];
        let request_url = 'https://tracking.bikroyit.com:5500/analytics_by_id/';

        let get_analytics = function(){
            //$('.live_campaign_indicator').css('display','none');
            let client_id = 0;
            $('table tbody tr').each(async function(item){
                let campaign_id = $(this).data('row_id');
                let response = await axios.get(request_url+client_id+'/'+campaign_id);
                let ctr = response.data[0] > 0 ? (response.data[1]/response.data[0])*100 : 0;
                let total_impression = $(this).find("[data-total_impression]").data('total_impression');
                let total_budget =  $(this).find("[data-total_budget]").data('total_budget');
                let budget_per_impression = total_budget/total_impression;
                let budget_spent = (Number(response.data[0])*budget_per_impression).toFixed(2);
                $(this).find('.budget_spent_badge').text(budget_spent+' TK')
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