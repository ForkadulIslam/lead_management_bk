
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
                            <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"><?php echo number_format($total_invoice_amount); ?> TK</div>
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
                                <h5 class="">Activity summary of this month</h5>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-xs-12">
                                <table class="table table-bordered table-striped font-12">
                                    <thead>
                                    <tr>
                                        <th>Sales lead</th>
                                        <?php $__currentLoopData = get_activity_list(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <th class="text-center"><?php echo $activity; ?></th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $executives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $executive): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo $executive->full_name; ?></td>
                                            <?php $__currentLoopData = get_activity_list(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <td class="text-center"><?php echo $executive->activities_of_this_month->where('type_of_activity',$key)->count(); ?></td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>