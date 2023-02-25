
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
                            <div class="text">TOTAL ACTIVE DEAL</div>
                            <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"><?php echo $total_active_deals; ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="info-box bg-light-green hover-expand-effect">
                        <div class="icon">
                            <i>৳</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL DEALS VALUE</div>
                            <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"><?php echo $total_invoice_amount; ?> TK</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-6">
                <div class="card">
                    <div class="header bg-teal">
                        <div class="row clearfix">
                            <div class="col-xs-12">
                                <h5 class="">Activity summary</h5>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-xs-12">
                                <table class="table table-bordered table-striped font-12">
                                    <thead>
                                        <tr>
                                            <th>Activity</th>
                                            <th class="text-center">This Month</th>
                                            <th class="text-center">Cumulative</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Meeting</td>
                                        <td class="text-center"><?php echo $meeting['this_month']; ?></td>
                                        <td class="text-center"><?php echo $meeting['cumulative']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Proposal Share</td>
                                        <td class="text-center"><?php echo $proposal_share['this_month']; ?></td>
                                        <td class="text-center"><?php echo $proposal_share['cumulative']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Followup Call</td>
                                        <td class="text-center"><?php echo $call['this_month']; ?></td>
                                        <td class="text-center"><?php echo $call['cumulative']; ?></td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <a href="<?php echo URL::to('module/activity'); ?>">Show more</a>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="card">
                    <div class="header bg-teal">
                        <div class="row clearfix">
                            <div class="col-xs-12">
                                <h5 class="">Upcoming activity</h5>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-xs-12">
                                <table class="table talbe-responsive table-striped table-bordered table-hovered text-left font-12">
                                    <tbody>
                                    <?php $__currentLoopData = $upcoming_activity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <p class="m-b-0 font-14"><?php echo $row->title; ?></p>
                                            </td>
                                            <td>
                                                <p><?php echo $row->start_time; ?></p>
                                            </td>
                                            <td>
                                                <?php if($row->linked_with == 1): ?>
                                                    <strong><?php echo isset($row->client->name) ? $row->client->name : 'N/A'; ?></strong>
                                                    <?php $__currentLoopData = $row->contact_persons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact_person): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <p class="m-b-0"> - <?php echo $contact_person->name; ?> &nbsp; <small>(<?php echo $contact_person->phone; ?>)</small></p>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                                <?php if($row->linked_with == 2): ?>
                                                    <strong><?php echo isset($row->deal->title) ? $row->deal->title : 'N/A'; ?></strong>
                                                    <?php $__currentLoopData = $row->contact_persons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact_person): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <p class="m-b-0"> - <?php echo $contact_person->name; ?> &nbsp; <small>(<?php echo $contact_person->phone; ?>)</small></p>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                                <?php if($row->linked_with == 3): ?>
                                                    <strong><?php echo isset($row->individual_contact_person->name) ? $row->individual_contact_person->name : 'N/A'; ?> </strong> <small>(<?php echo $row->individual_contact_person->phone; ?>)</small>
                                                    <p class="m-b-0"> - <?php echo isset($row->individual_contact_person->client->name) ? $row->individual_contact_person->client->name : 'N/A'; ?></p>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <a href="<?php echo URL::to('module/activity'); ?>">Show more</a>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
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
                                <h5 class="">Lost Deals</h5>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-xs-12">
                                <p>TOTAL LOST DEALS: <?php echo $lost_deal->total();; ?></p>
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
                                    <?php $__currentLoopData = $lost_deal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
            $('.datepicker').bootstrapMaterialDatePicker({
                format: 'YYYY-MM-DD',
                clearButton: true,
                weekStart: 1,
                time: false
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>