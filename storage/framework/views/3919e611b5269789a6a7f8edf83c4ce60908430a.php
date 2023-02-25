
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="block-header">
            <a href="<?php echo URL::to('module/lead'); ?>" class="btn btn-sm btn-primary"> <i class="material-icons">list</i> Leads bucket</a>
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
                            Upload
                        </h2>
                    </div>
                    <div class="body" id="app">
                        <div class="row clearfix">
                            <?php echo Form::open(['url'=>URL::to('module/lead/store'),'class'=>'form','files'=>'true']); ?>

                            <div class="col-xs-6">
                                <label for="">EXCEL/CSV</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">attach_file</i>
                                    </span>
                                    <div class="form-line">
                                        <?php echo Form::file('file',['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="submit" value="IMPORT" class="btn btn-success btn-md btn-block">
                                </div>
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