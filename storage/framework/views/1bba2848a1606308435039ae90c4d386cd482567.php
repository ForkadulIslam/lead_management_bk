
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
                            <div class="text">TOTAL CLIENT</div>
                            <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20">257</div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="info-box bg-light-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">attach_money</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL INVOICE AMOUNT</div>
                            <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20">25,700 TK</div>
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
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Activity</th>
                                            <th class="text-center">This week</th>
                                            <th class="text-center">This Month</th>
                                            <th class="text-center">Cumulative</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Meeting</td>
                                        <td class="text-center">2</td>
                                        <td class="text-center">10</td>
                                        <td class="text-center">20</td>
                                    </tr>
                                    <tr>
                                        <td>Proposal Share</td>
                                        <td class="text-center">1</td>
                                        <td class="text-center">0</td>
                                        <td class="text-center">2</td>
                                    </tr>
                                    <tr>
                                        <td>Followup Call</td>
                                        <td class="text-center">0</td>
                                        <td class="text-center">5</td>
                                        <td class="text-center">9</td>
                                    </tr>
                                    </tbody>
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
                                <h5 class="">Deals summary</h5>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-xs-12">
                                <table class="table talbe-responsive table-striped table-bordered table-hovered text-center">
                                    <thead>
                                    <tr>
                                        <th class="text-left">Deals</th>
                                        <th class="text-center">Open</th>
                                        <th class="text-center">Close</th>
                                        <th class="text-center">Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="text-left">This week</td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>10,000TK</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">This Month</td>
                                        <td>2</td>
                                        <td>1</td>
                                        <td>50,000TK</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Cumulative</td>
                                        <td>3</td>
                                        <td>2</td>
                                        <td>80,000TK</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
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
                                <h5 class="">Upcoming activity</h5>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-xs-12">
                                <table class="table talbe-responsive table-striped table-bordered table-hovered text-left font-12">
                                    <thead>
                                    <tr>
                                        <th>Activity</th>
                                        <th>With</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $upcoming_activity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <p class="m-b-0 font-14"><?php echo $row->title; ?></p>
                                                <p class="m-b-0 font-12 font-italic"><?php echo get_activity_list()[$row->type_of_activity]; ?> - <?php echo $row->start_time; ?></p>
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
                                            <td colspan="2" class="text-center">
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
                                <h5 class="">Others</h5>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="row clearfix">

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