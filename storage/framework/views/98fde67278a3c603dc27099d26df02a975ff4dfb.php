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
                        <p>Client: <?php echo isset($results->first()->campaign->client->name) ? $results->first()->campaign->client->name : 'N/A';; ?></p>
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-striped table-bordered table-hover table-responsive">
                            <thead>
                            <tr>
                                <th style="width:200px;">Creative</th>
                                <th style="width: 115px">Impression</th>
                                <th style="width: 100px">Click</th>
                                <th style="width: 200px">CTR</th>
                                <th class="text-center" style="width: 40px;">#</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr data-creative="<?php echo $result->size; ?>" class="font-12">
                                        <td style="position: relative">
                                            <?php echo $result->size; ?>

                                            <img class="live_campaign_indicator" src="<?php echo asset('public/images/live.gif'); ?>" alt="Live image icon">
                                        </td>
                                        <td class="impression_badge"></td>
                                        <td class="click_badge"></td>
                                        <td class="ctr_badge"></td>
                                        <td class="text-center">
                                            <a data-id="<?php echo $result->campaign_id; ?>" data-size="<?php echo $result->size; ?>" data-toggle="tooltip" data-title="Copy code" href="#" class="btn btn-xs btn-info generate_code">
                                                <i class="material-icons">file_copy</i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
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

        })

    </script>

    <script type="text/javascript">
        let request_arr = [];
        let request_url = 'https://tracking.bikroyit.com:5500/analytics_by_creative/';

        let get_analytics = function(){
            //$('.live_campaign_indicator').css('display','none');
            let client_id = '<?php echo $results->first()->campaign->client_id; ?>';
            let campaign_id = <?php echo $results->first()->campaign->id; ?>;
            $('table tbody tr').each(async function(item){
                let creative = $(this).data('creative');
                let response = await axios.get(request_url+client_id+'/'+campaign_id+'/'+creative);
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


            $('.generate_code').click(function(e){
                e.preventDefault();
                let size_arr = $(this).data('size').split('x');
                let width = size_arr[0];
                let height = size_arr[1];
                let template = '<iframe src="<?php echo url('html_contents/html'); ?>/'+$(this).data('id')+'/'+$(this).data('size')+'.html" height="'+height+'" width="'+width+'" style="border:none" scrolling="no"></iframe>';
                let $temp = $("<input>");
                $("body").append($temp);
                $temp.val(template).select();
                document.execCommand("copy");
                $temp.remove();
                toast('Code copied...');
            })
        })

    </script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layouts.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>