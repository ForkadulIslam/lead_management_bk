
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
            <div class="row">
                <div class="col-xs-6">
                    <div class="info-box bg-pink hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">perm_identity</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL LEADS</div>
                            <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"><?php echo $total_leads; ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="info-box bg-light-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">perm_identity</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL QUEUE</div>
                            <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"><?php echo $queue_leads; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-xs-12">
                <div class="card">
                    <div class="header bg-teal">
                        <div class="row clearfix">
                            <div class="col-xs-12">
                                <h5 class="">Activity summary of this month</h5>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-xs-12">
                                <table class="table table-bordered table-striped font-12">
                                    <thead>
                                    <tr>
                                        <th>Agent</th>
                                        <?php $__currentLoopData = get_activity_list(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <th class="text-center"><?php echo $activity; ?></th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $executives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $executive): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo $executive->full_name; ?></td>
                                            <?php $__currentLoopData = get_activity_list(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <td class="text-center"><?php echo $executive->activities_of_this_month()->where('calling_status',$key)->count(); ?></td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>

                                </table>
                            </div>
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

        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>