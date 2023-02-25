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
            <a href="<?php echo URL::to('module/lead'); ?>" class="btn btn-xs btn-primary"> <i class="material-icons">add_circle_outline</i> Go to lead</a>
        </div>

        <!-- Striped Rows -->
        <div class="row clearfix" id="app">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="col-xs-6">
                                <h4><?php echo $lead->name; ?></h4>
                                <p class="m-b-0">Contact: <?php echo $lead->phone; ?> || Status: <?php echo $lead->calling_queue->calling_status; ?></p>
                                <p class="m-b-0 badge">
                                    <strong>Status</strong> : <?php echo $lead->calling_queue->calling_status; ?>

                                    <?php if($lead->calling_queue->status_sub_type): ?>
                                    / <small class="text-muted"><?php echo $lead->calling_queue->status_sub_type; ?></small>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="col-xs-6 text-right">
                                <p class="badge bg-pink"><?php echo isset($lead->calling_queue->user->full_name) ? $lead->calling_queue->user->full_name : 'N/A'; ?> : Agent</p>
                                <p class="m-b-0">Call : <?php echo $lead->calling_queue()->where('status',1)->count(); ?></p>
                                <p class="m-b-0">Followup : <?php echo $lead->follow_up()->where('status',1)->count(); ?></p>
                                <p class="m-b-0">Remarks: <?php echo $lead->calling_queue->remarks; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="body table-responsive">
                        <div class="row clearfix">

                        </div>
                        <table class="table table-striped table-bordered table-hover table-responsive">
                            <thead class="bg-teal">
                            <tr>
                                <th style="width:60px;">SL</th>
                                <th style="width: 150px">Name</th>
                                <th style="width: 100px">Phone</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Remarks</th>
                            </tr>
                            </thead>
                            <tbody>

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



    </script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layouts.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>