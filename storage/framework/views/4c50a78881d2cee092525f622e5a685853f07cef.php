
<?php $__env->startSection('custom_page_style'); ?>
    <style>
        table td{
            vertical-align: middle!important;
        }
        .activity_tag{
            position: absolute;
            top: 0;
            right: 0;
            font-size: 9px;
            font-style: italic;
            background: #009877;
            color: #fff;
            padding: 2px;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="block-header">
            <a href="<?php echo URL::to('module/activity'); ?>"><strong>List of activity</strong></a>
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
                        <a href="<?php echo URL::to('module/activity/create'); ?>" class="btn btn-xs btn-primary"> <i class="material-icons">add_circle_outline</i> Create new activity</a>
                    </div>
                    <div class="body table-responsive">
                        <?php echo Form::open(['url'=>URL::to('module/activity/search'),'method'=>'post']); ?>

                        <div class="row clearfix">

                            <div class="col-xs-2">
                                <div class="input-group" style="margin-bottom:0px;">
                                    <span class="input-group-addon">
                                        <i class="material-icons">date_range</i>
                                    </span>
                                    <div class="form-line">
                                        <?php echo Form::text('from',$request->from ? $request->from : \Carbon\Carbon::now()->toDateString(),['class'=>'form-control datepicker','placeholder'=>'From..']); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="input-group" style="margin-bottom:0px;">
                                    <span class="input-group-addon">
                                        <i class="material-icons">date_range</i>
                                    </span>
                                    <div class="form-line">
                                        <?php echo Form::text('to',$request->to ? $request->to : \Carbon\Carbon::now()->toDateString(),['class'=>'form-control datepicker','placeholder'=>'To..']); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="input-group" style="margin-bottom:0px;">
                                    <div class="form-line">
                                        <?php echo Form::select('status',get_activity_status(),$request->status ? $request->status : null,['class'=>'selectpicker','data-width'=>'fit','title'=>'--Status--']); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="input-group" style="margin-bottom:0px;">
                                    <div class="form-line">
                                        <?php echo Form::select('executive_id',\App\User::where('roll_id',2)->pluck('full_name','id'),$request->executive_id ? $request->executive_id : null,['class'=>'form-control selectpicker','placeholder'=>'--Executive--']); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="input-group" style="margin-bottom:0px;">
                                    <div class="form-line">
                                        <?php echo Form::select('activity',get_activity_list(),$request->activity ? $request->activity : null,['class'=>'form-control selectpicker','placeholder'=>'--Activity--',]); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="input-group">
                                    <?php echo Form::submit('SEARCH',['class'=>'btn btn-success btn-block']); ?>

                                </div>
                            </div>
                        </div>
                        <?php echo Form::close(); ?>

                        <p>TOTAL ACTIVITY: <?php echo $data->total();; ?></p>
                        <table class="table table-striped table-bordered table-hover table-responsive">
                            <thead>
                            <tr>
                                <th style="width:250px;">Title</th>
                                <th>Executives</th>
                                <th style="width:155px">Start time</th>
                                <th style="width:155px">End time</th>
                                <th>Activity</th>
                                <th>Status</th>
                                <th style="width:100px;">Option</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="font-12">
                                <td style="width:250px;position:relative;">

                                    <?php if($row->linked_with == 1): ?>
                                        <?php 
                                        $title = [];
                                        foreach($row->contact_persons as $contact_person){
                                            $title[]= $contact_person->name;
                                        }
                                         ?>
                                        <spna class="activity_tag">Client</spna>
                                        <p  data-toggle="tooltip" data-title="<?php echo implode(',',$title); ?>" class="m-b-0"><strong><?php echo $row->title; ?></strong></p>
                                        <p data-toggle="tooltip" data-title="<?php echo implode(',',$title); ?>" class="font-11 font-italic m-b-0"><?php echo isset($row->client->name) ? $row->client->name : 'N/A'; ?></p>
                                    <?php endif; ?>
                                        <?php if($row->linked_with == 2): ?>
                                            <?php 
                                                $title = [];
                                                foreach($row->contact_persons as $contact_person){
                                                    $title[]= $contact_person->name;
                                                }
                                             ?>
                                            <spna class="activity_tag">Deals</spna>
                                            <p  data-toggle="tooltip" data-title="<?php echo implode(',',$title); ?>" class="m-b-0"><strong><?php echo $row->title; ?></strong></p>
                                            <p data-toggle="tooltip" data-title="<?php echo implode(',',$title); ?>" class="font-11 font-italic m-b-0"><?php echo isset($row->deal->title) ? $row->deal->title : 'N/A'; ?></p>
                                        <?php endif; ?>
                                    <?php if($row->linked_with == 3): ?>
                                        <spna class="activity_tag">Individual</spna>
                                        <p data-toggle="tooltip" data-title="<?php echo isset($row->individual_contact_person->client->name) ? $row->individual_contact_person->client->name : 'N/A'; ?>" class="font-12 font-italic"><?php echo isset($row->individual_contact_person->name) ? $row->individual_contact_person->name : 'N/A'; ?></p>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <p class="m-b-0"> - <?php echo isset($row->executive->full_name) ? $row->executive->full_name : 'N/A'; ?></p>
                                </td>
                                <td>
                                    <p class="m-b-0"><?php echo $row->start_time; ?></p>
                                    <small class="font-bold text-success">
                                        <?php 
                                            $diff = 'N/A';
                                            if($row->start_time){
                                                $start_time = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$row->start_time);
                                                $diff = $start_time->diffForHumans(\Carbon\Carbon::now());
                                            }
                                         ?>
                                        <?php echo $diff; ?>

                                    </small>
                                </td>
                                <td>
                                    <p><?php echo $row->end_time; ?></p>
                                </td>
                                <td>
                                    <p><?php echo get_activity_list()[$row->type_of_activity]; ?></p>
                                </td>
                                <td>
                                    <?php if($row->status ==1): ?>
                                        <p class="btn btn-xs btn-warning"><?php echo get_activity_status()[$row->status]; ?></p>
                                    <?php elseif($row->status ==2): ?>
                                        <p class="btn btn-xs btn-info"><?php echo get_activity_status()[$row->status]; ?></p>
                                    <?php else: ?>
                                        <p class="btn btn-xs btn-danger"><?php echo get_activity_status()[$row->status]; ?></p>
                                    <?php endif; ?>
                                </td>
                                <td style="width:100px;">
                                    <a data-toggle="tooltip" data-title="View" class="btn btn-xs btn-warning" href="<?php echo URL::to('module/activity/'.$row->id,'edit'); ?>"><i class="material-icons">edit</i></a>
                                    <a data-toggle="tooltip" data-title="Delete" class="btn btn-xs btn-danger delete_with_swal" href="<?php echo URL::to('module/activity',$row->id); ?>"><i class="material-icons">remove</i></a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
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