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
            <a href="<?php echo URL::to('module/calling_queue'); ?>"><strong>Reload</strong></a>
        </div>

        <!-- Striped Rows -->
        <div class="row clearfix" id="app">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <a href="<?php echo URL::to('module/calling_queue/create'); ?>" class="btn btn-xs btn-primary"> <i class="material-icons">add_circle_outline</i> Go to queue</a>
                    </div>
                    <div class="body table-responsive">
                        <?php echo Form::open(['url'=>URL::to('module/calling_queue/search'),'method'=>'post']); ?>

                        <div class="row clearfix">

                            <div class="col-xs-3">
                                <div class="input-group" style="margin-bottom:0px;">
                                    <span class="input-group-addon">
                                        <i class="material-icons">perm_identity</i>
                                    </span>
                                    <div class="form-line">
                                        <?php echo Form::text('from',request()->from ? request()->from : \Carbon\Carbon::now()->toDateString(),['class'=>'form-control datepicker', 'placeholder'=>'From..']); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group" style="margin-bottom:0px;">
                                    <span class="input-group-addon">
                                        <i class="material-icons">perm_identity</i>
                                    </span>
                                    <div class="form-line">
                                        <?php echo Form::text('to',request()->to ? request()->to : \Carbon\Carbon::now()->toDateString(),['class'=>'form-control datepicker', 'placeholder'=>'To..']); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">file_copy</i>
                                    </span>
                                    <div class="">
                                        <?php echo Form::select('calling_status',get_activity_list(),request()->calling_status ? request()->calling_status : null,['class'=>'selectpicker','title'=>'--Status--','data-width'=>'100%','placeholder'=>'--Status--']); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group">
                                    <?php echo Form::submit('SEARCH',['class'=>'btn btn-success btn-block']); ?>

                                </div>
                            </div>
                        </div>
                        <?php echo Form::close(); ?>

                        <p>TOTAL LEAD: <?php echo $queue->count();; ?></p>
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
                            <?php $__currentLoopData = $queue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="font-12">
                                <td style="width:50px;"><?php echo ($i+1); ?></td>
                                <td><?php echo $lead->lead->name; ?></td>
                                <td><?php echo $lead->lead->phone; ?></td>
                                <td><?php echo $lead->lead->category; ?></td>
                                <td>
                                    <?php echo $lead->calling_status; ?>

                                    <?php if($lead->status_sub_type): ?>
                                    / <small><?php echo $lead->status_sub_type; ?></small>
                                    <?php endif; ?>
                                </td>
                                <th>
                                    <?php echo $lead->remarks; ?>

                                </th>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php echo $queue->appends(request()->except(['_token']))->links(); ?>

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
            $('.delete_with_swal').click(function(e){
                e.preventDefault();
                delete_with_swal($(this).attr('href'),'<?php echo csrf_token(); ?>',$(this).closest('tr'));
            })
        })

    </script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layouts.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>