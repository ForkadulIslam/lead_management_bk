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
            <a href="<?php echo URL::to('module/client/contact_person_list'); ?>">
                <strong>All contact person</strong>
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
                    </div>
                    <div class="body table-responsive">
                        <?php echo Form::open(['url'=>URL::to('module/client/search_contact_person'),'method'=>'post']); ?>

                        <div class="row clearfix">

                            <div class="col-xs-6">
                                <div class="input-group" style="margin-bottom:0px;">
                                    <span class="input-group-addon">
                                        <i class="material-icons">perm_identity</i>
                                    </span>
                                    <div class="form-line">
                                        <?php echo Form::text('name',$request->name,['class'=>'form-control','placeholder'=>'Contact person name']); ?>

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

                        <table class="table table-striped table-bordered table-hover table-responsive">
                            <thead>
                            <tr>
                                <th style="width:250px;">Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Client name</th>
                                <th>Created by</th>
                                <th style="width:100px;">Option</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $contact_persons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="font-12">
                                <td style="width:250px;">
                                    <a href="<?php echo URL::to('module/client/contact_person_details',$row->id); ?>" data-toggle="tooltip" data-title="View member details"><?php echo $row->name; ?></a>
                                    <p class="margin-0"><?php echo $row->designation; ?>, <?php echo $row->department; ?></p>
                                </td>
                                <td>
                                    <p class="margin-0"><?php echo $row->email; ?></p>
                                </td>
                                <td>
                                    <p class="margin-0"><?php echo $row->phone; ?></p>
                                </td>
                                <td>
                                    <?php echo isset($row->client->name) ? $row->client->name : 'N/A'; ?>

                                </td>
                                <td>
                                    <?php echo isset($row->creator->full_name) ? $row->creator->full_name : 'N/A'; ?>

                                </td>
                                <td style="width:100px;">
                                    <a data-toggle="tooltip" data-title="Show details" class="btn btn-xs btn-info" href="<?php echo URL::to('module/client/contact_person_details',$row->id); ?>"><i class="material-icons">preview</i></a>
                                    <a data-toggle="tooltip" data-title="Edit" class="btn btn-xs btn-warning" href="<?php echo URL::to('module/client/edit_contact_person',$row->id); ?>"><i class="material-icons">edit</i></a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php echo $contact_persons->appends($request->except(['_token']))->links(); ?>

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