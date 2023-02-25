
<?php $__env->startSection('custom_page_style'); ?>
    <style>
        .contact_person_created_by{
            position: absolute;
            right: 5px;
            font-size: 12px;
            font-style: italic;
            background: #dbdbdb;
            padding: 2px 10px;
            border-radius: 23px;
        }
        table td{
            vertical-align: middle!important;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="block-header">
            <a href="<?php echo URL::to('module/client/contact_person_list'); ?>">All contact persons</a>
        </div>
        <!-- Color Pickers -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="col-xs-4">
                                <p class="m-b-0"><small><strong><?php echo $contact_person->name; ?></strong></small></p>
                                <small><?php echo $contact_person->designation; ?> at <?php echo $contact_person->department; ?></small>
                            </div>
                            <div class="col-xs-4">
                                <p class="m-b-0"><strong>Executives</strong></p>
                                <?php $__currentLoopData = $client->owner; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $executive): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <p><?php echo $executive->full_name; ?></p>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div class="col-xs-4">
                                <p class="text-right m-b-0 font-11">Onboard: <?php echo $contact_person->created_at; ?></p>
                                <span class="contact_person_created_by">Created by: <?php echo isset($contact_person->creator->full_name) ? $contact_person->creator->full_name : 'N/A'; ?></span>
                            </div>
                        </div>

                    </div>
                    <div class="body" id="app">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="panel-group">
                                            <div class="panel panel-col-grey">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title clearfix">
                                                        <a class="pull-left">
                                                            <i class="material-icons">perm_contact_calendar</i> Client details
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div>
                                                    <div class="panel-body">
                                                        <div class="card" style="margin-bottom: 0px;">
                                                            <div class="body clearfix">
                                                                <ul class="list-group m-b-0">
                                                                    <li class="list-group-item">
                                                                        <p class="m-b-0"><strong><?php echo $client->name; ?></strong></p>
                                                                        <p class="font-12 m-b-0"><?php echo $client->industry; ?></p>
                                                                        <p class="font-12 m-b-0"><?php echo $client->address; ?></p>

                                                                        <p class="font-italic m-b-0"></p>
                                                                    </li>
                                                                </ul>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="panel-group">
                                            <div class="panel panel-col-grey">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title clearfix">
                                                        <a class="pull-left">
                                                            <i class="material-icons">perm_contact_calendar</i> Activities
                                                        </a>
                                                        <a data-toggle="modal" data-target="#myModal" class="pull-right" href="#">
                                                            <i data-toggle="tooltip" data-title="Create new activity" class="material-icons">add</i>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div>
                                                    <div class="panel-body">
                                                        <div class="card" style="margin-bottom: 0px;">
                                                            <div class="body">
                                                                <ul class="">
                                                                    <?php $__currentLoopData = get_activity_list(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <li>
                                                                        <?php echo $activity; ?>

                                                                        <span class="pull-right"><b><?php echo $client->activities->where('type_of_activity',$key)->count(); ?></b></span>
                                                                    </li>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </ul>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- #END# Color Pickers -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Details of your activity</h4>
                    </div>
                    <div class="modal-body">
                        <?php echo Form::open(['url'=>URL::to('module/activity'),'class'=>'form']); ?>

                        <?php echo Form::hidden('linked_with',3); ?>

                        <?php echo Form::hidden('id_of_linked_with',$contact_person->id); ?>

                        <div class="row">
                            <div class="col-xs-6">
                                <label for="">Title</label>
                                <div class="input-group">
                                    <span id="" class="input-group-addon">
                                        <i class="material-icons">title</i>
                                    </span>
                                    <div class="form-line focused" style="margin-bottom: 0px;">
                                        <?php echo Form::text('title',null,['class'=>'form-control','placeholder'=>'Title of activity','autocomplete'=>"off",'required'=>'required']); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <label for="">Type of activity</label>
                                <div class="input-group">
                                    <?php echo Form::select('type_of_activity',get_activity_list(),null,['class'=>'selectpicker','required'=>'required']); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <label for="">Start time</label>
                                <div class="input-group">
                                    <span id="" class="input-group-addon">
                                        <i class="material-icons">date_range</i>
                                    </span>
                                    <div class="form-line" style="margin-bottom: 0px;">
                                        <?php echo Form::text('start_time',null,['class'=>'form-control datetimepicker','placeholder'=>'Start time..','required'=>'required']); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <label for="">End time <small>(optional)</small></label>
                                <div class="input-group">
                                    <span id="" class="input-group-addon">
                                        <i class="material-icons">date_range</i>
                                    </span>
                                    <div class="form-line" style="margin-bottom: 0px;">
                                        <?php echo Form::text('end_time',null,['class'=>'form-control datetimepicker','placeholder'=>'End time..']); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="">Remarks</label>
                                <div class="input-group">
                                    <span id="" class="input-group-addon">
                                        <i class="material-icons">title</i>
                                    </span>
                                    <div class="form-line" style="margin-bottom: 0px;">
                                        <?php echo Form::textarea('remarks',null,['class'=>'form-control','placeholder'=>'Remarks','rows'=>'2','cols'=>'1']); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <input type="submit" name="submit" value="SAVE" class="btn btn-success btn-md btn-block">
                                </div>
                            </div>
                        </div>
                        <?php echo Form::close(); ?>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('custom_page_script'); ?>
    <script type="text/javascript">
        var app = new Vue({
            el:'#app',
            data:{

            },
            methods:{
                submit_invoice_search:function(){
                    $('#invoice_search').submit();
                }
            }
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.datetimepicker').bootstrapMaterialDatePicker({
                format: 'Y-MM-DD HH:mm:ss',
                clearButton: true,
                weekStart: 1
            });
        });

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>