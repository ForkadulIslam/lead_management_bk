
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="block-header">
            <a href="<?php echo URL::to('module/executive'); ?>" class="btn btn-sm btn-primary"> <i class="material-icons">list</i> Executive lists</a>
            <?php if(Session::has('message')): ?>
                <div class="alert alert-success alert-dismissible show" role="alert">
                    <strong>Congratulation</strong> <?php echo Session::get('message'); ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
        </div>
        <!-- Color Pickers -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Executive creation form
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else here</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body" id="app">
                        <div class="row clearfix">
                            <?php echo Form::open(['url'=>URL::to('module/executive'),'class'=>'form','files'=>'true']); ?>

                            <div class="col-xs-3">
                                <label for="">Name</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">person</i>
                                    </span>
                                    <div class="form-line">
                                        <?php echo Form::text('full_name',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <label for="">Phone</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">phone</i>
                                    </span>
                                    <div class="form-line">
                                        <?php echo Form::text('phone',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <label for="">Login ID</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">person</i>
                                    </span>
                                    <div class="form-line">
                                        <?php echo Form::text('email',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <label for="">Password</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">lock</i>
                                    </span>
                                    <div class="form-line">
                                        <?php echo Form::password('password',['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="submit" value="SAVE" class="btn btn-success btn-lg">
                                </div>
                            </div>
                           <div class="col-xs-9">


                           </div>
                            <?php echo Form::close(); ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- #END# Color Pickers -->

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('custom_page_script'); ?>
    <script type="text/javascript">

        var app = new Vue({
            el:'#app',
            data:{

            },
            mounted() {

            },
            methods:{


            }
        });
        $('document').ready(function(){

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>