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
            <a href="<?php echo URL::to('module/client'); ?>">
                <strong>Client lists</strong>
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
                        <a href="<?php echo URL::to('module/client/create'); ?>" class="btn btn-xs btn-primary"> <i class="material-icons">add_circle_outline</i> Create new client</a>
                        <?php if(auth()->user()->roll_id == 1): ?>
                        <a href="<?php echo URL::to('download_client'); ?>" class="btn btn-xs pull-right"> <i class="material-icons"></i> Download client list</a>
                        <?php endif; ?>
                    </div>
                    <div class="body table-responsive">
                        <?php echo Form::open(['url'=>URL::to('module/client/search'),'method'=>'post']); ?>

                        <div class="row clearfix">

                            <div class="col-xs-3">
                                <div class="input-group" style="margin-bottom:0px;">
                                    <span class="input-group-addon">
                                        <i class="material-icons">perm_identity</i>
                                    </span>
                                    <div class="form-line">
                                        <?php echo Form::text('name',$request->name,['class'=>'form-control','placeholder'=>'Client name']); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group" style="margin-bottom:0px;">
                                    <span class="input-group-addon">
                                        <i class="material-icons">perm_identity</i>
                                    </span>
                                    <div class="form-line">
                                        <?php echo Form::select('executive_ids[]',\App\User::where('roll_id',2)->pluck('full_name','id'),$request->executive_ids ? $request->executive_ids : null,['class'=>'form-control selectpicker','title'=>'--Executive--','multiple'=>'true']); ?>

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

                        <p>TOTAL CLIENT: <?php echo $clients->total();; ?></p>
                        <table class="table table-striped table-bordered table-hover table-responsive">
                            <thead>
                            <tr>
                                <th style="width:250px;">Name</th>
                                <th style="width: 115px">On-board Date</th>
                                <th>Contact person</th>
                                <th>Executive/Owner</th>
                                <th style="width:100px;">Option</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="font-12">
                                <td style="width:250px;">
                                    <a href="<?php echo URL::to('module/client',$client->id); ?>" data-toggle="tooltip" data-title="View member details"><?php echo $client->name; ?></a>
                                </td>
                                <td>
                                    <p class="margin-0"><?php echo $client->created_at->toDateString(); ?></p>
                                    <p><small><strong><?php echo \Carbon\Carbon::parse($client->created_at)->diffForHumans(); ?></strong></small></p>
                                </td>
                                <td>
                                    <ul>
                                        <?php $__currentLoopData = $client->contact_persons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact_person): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li>
                                                <p class="margin-0"><?php echo $contact_person->name; ?></p>
                                                <small><?php echo $contact_person->phone; ?></small>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </td>
                                <td>
                                    <?php $__currentLoopData = $client->owner; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $owner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <p class="m-b-0">-<?php echo $owner->full_name; ?></p>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td style="width:100px;">
                                    <a data-toggle="tooltip" data-title="Edit" class="btn btn-xs btn-warning" href="<?php echo URL::to('module/client/'.$client->id,'edit'); ?>"><i class="material-icons">edit</i></a>
                                    <a data-toggle="tooltip" data-title="Delete" class="btn btn-xs btn-danger delete_with_swal" href="<?php echo URL::to('module/client',$client->id); ?>"><i class="material-icons">remove</i></a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Member allocation</h4>
                                        <p>At first select members from left side of the table</p>
                                    </div>
                                    <div class="modal-body">
                                        <div class="input-group">
                                            <?php echo Form::select('executive_id',$executives,$request->executive_id,['class'=>'form-control','data-live-search'=>'true','placeholder'=>'--Executive--']); ?>

                                        </div>
                                        <div class="input-group">
                                            <?php echo Form::submit('SAVE',['class'=>'btn btn-lg btn-success']); ?>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo Form::close(); ?>

                        <?php echo $clients->appends($request->except(['_token']))->links(); ?>

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
            $('#select_all').change(function() {
                $('[name="member_id[]"]').click();

            });

            $('#executive_allocation').click(function(e){
                e.preventDefault();
                //$('#table_form').submit();
            })
        })

    </script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layouts.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>