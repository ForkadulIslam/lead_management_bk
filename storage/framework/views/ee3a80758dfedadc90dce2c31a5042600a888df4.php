
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
            <a href="<?php echo URL::to('module/deals'); ?>"><strong>List of deal</strong></a>
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
                        <a href="<?php echo URL::to('module/deals/create'); ?>" class="btn btn-xs btn-primary"> <i class="material-icons">add_circle_outline</i> Create new deal</a>
                    </div>
                    <div class="body table-responsive">
                        <?php echo Form::open(['url'=>URL::to('module/deals/search'),'method'=>'post']); ?>

                        <div class="row clearfix">

                            <div class="col-xs-3">
                                <div class="input-group" style="margin-bottom:0px;">
                                    <span class="input-group-addon">
                                        <i class="material-icons">perm_identity</i>
                                    </span>
                                    <div class="form-line">
                                        <?php echo Form::text('client_name',$request->client_name ? $request->client_name : null,['class'=>'form-control','placeholder'=>'Client name']); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group" style="margin-bottom:0px;">
                                    <span class="input-group-addon">
                                        <i class="material-icons">perm_identity</i>
                                    </span>
                                    <div class="form-line">
                                        <?php echo Form::select('executive_id',\App\User::where('roll_id',2)->pluck('full_name','id'),$request->executive_id ? $request->executive_id : null,['class'=>'form-control selectpicker','placeholder'=>'--Executive--']); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">file_copy</i>
                                    </span>
                                    <div class="">
                                        <?php echo Form::select('stage',get_deals_stage(),$request->stage ? $request->stage : null,['class'=>'selectpicker','title'=>'--Stage--','data-width'=>'fit','placeholder'=>'--Stage--']); ?>

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

                        <?php echo Form::open(['url'=>URL::to('module/member/table_action'),'id'=>'table_form']); ?>

                        <p>TOTAL DEALS: <?php echo $data->total();; ?></p>
                        <table class="table table-striped table-bordered table-hover table-responsive">
                            <thead>
                            <tr>
                                <th style="width:250px;">Title</th>
                                <th>
                                    Assigned Executives
                                </th>
                                <th style="width:101px;">Creation Date</th>
                                <th style="width:101px;">Closing Date</th>
                                <th>Amount</th>
                                <th>Stage</th>
                                <th style="width:100px;">Option</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="font-12">
                                <td style="width:250px;">
                                    <?php 
                                    $title = [];
                                    foreach ($row->contactPersons as $contactPerson){
                                        $title[] = $contactPerson->name;
                                    }
                                     ?>
                                    <a href="<?php echo URL::to('module/deals',$row->id); ?>" data-toggle="tooltip" data-title="<?php echo implode(',',$title); ?>"><?php echo $row->title; ?></a>
                                    <p class="m-b-0 font-11 font-italic"><?php echo isset($row->client->name) ? $row->client->name : 'N/A'; ?></p>
                                </td>
                                <td>
                                    <?php $__currentLoopData = $row->executives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $executive): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <p class="m-b-0"> - <?php echo $executive->full_name; ?></p>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td>
                                    <p class="m-b-0"><?php echo $row->creation_date; ?></p>
                                    <small class="font-bold text-success">
                                        <?php 
                                            $start_time = \Carbon\Carbon::createFromFormat('Y-m-d',$row->creation_date);
                                            $diff = $start_time->diffForHumans(\Carbon\Carbon::now());
                                         ?>
                                        <?php echo $diff; ?>

                                    </small>
                                </td>
                                <td>
                                    <p><?php echo $row->closing_date; ?></p>
                                </td>
                                <td>
                                    <p><?php echo $row->amount; ?> TK</p>
                                </td>
                                <td>
                                    <p><?php echo $row->stage; ?></p>
                                </td>
                                <td style="width:100px;">
                                    <a data-toggle="tooltip" data-title="Edit" class="btn btn-xs btn-warning" href="<?php echo URL::to('module/deals/'.$row->id,'edit'); ?>"><i class="material-icons">edit</i></a>
                                    <a data-toggle="tooltip" data-title="Delete" class="btn btn-xs btn-danger delete_with_swal" href="<?php echo URL::to('module/deals',$row->id); ?>"><i class="material-icons">remove</i></a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                        <?php echo Form::close(); ?>

                        <?php echo $data->appends($request->except(['_token']))->links(); ?>

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