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
            <a href="<?php echo URL::to('module/lead'); ?>"><strong>Reload</strong></a>
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
                        <a href="<?php echo URL::to('module/lead/create'); ?>" class="btn btn-xs btn-primary"> <i class="material-icons">add_circle_outline</i> Import leads</a>
                    </div>
                    <div class="body table-responsive">
                        <?php echo Form::open(['url'=>URL::to('module/member/table_action'),'id'=>'table_form']); ?>

                        <p>TOTAL LEAD: <?php echo $leads->total();; ?></p>
                        <table class="table table-striped table-bordered table-hover table-responsive">
                            <thead class="bg-teal">
                            <tr>
                                <th style="width:60px;">SL</th>
                                <th style="width: 150px">Name</th>
                                <th style="width: 100px">Phone</th>
                                <th style="width:101px;">Source</th>
                                <th style="width:101px;">Category</th>
                                <th style="width:100px;">Agent</th>
                                <th style="width: 85px" class="text-center">No of attempt</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="font-12">
                                <td style="width:50px;"><?php echo ($i+1); ?></td>
                                <td><?php echo $lead->name; ?></td>
                                <td><?php echo $lead->phone; ?></td>
                                <td><?php echo $lead->source; ?></td>
                                <td><?php echo $lead->category; ?></td>
                                <td style="width:100px;">
                                    <?php echo isset($lead->calling_queue->user->full_name) ? $lead->calling_queue->user->full_name : 'N/A'; ?>

                                </td>
                                <td class="text-center">
                                    <a href="<?php echo url('module/lead/activity_details',$lead->id); ?>">
                                        <span class="badge bg-pink"><?php echo $lead->no_of_attempts; ?></span>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                        <?php echo Form::close(); ?>

                        <?php echo $leads->appends(request()->except(['_token']))->links(); ?>

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