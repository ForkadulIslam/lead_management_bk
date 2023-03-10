
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="block-header">
            <a href="<?php echo URL::to('module/campaign'); ?>" class="btn btn-sm btn-primary"> <i class="material-icons">list</i> Campaign lists</a>
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
                            Create new campaign
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
                            <?php echo Form::open(['url'=>URL::to('module/campaign'),'class'=>'form','files'=>'true']); ?>

                            <div class="col-xs-6">
                                <div class="card">
                                    <div class="header">
                                        <h4 class="card-title">Campaign information</h4>
                                    </div>
                                    <div class="body">
                                        <label for="">Client name</label>
                                        <div class="input-group">
                                            <span id="" class="input-group-addon">
                                                <i class="material-icons">person</i>
                                            </span>
                                            <div class="form-line autoCompleter" style="margin-bottom: 0px;">
                                                <input type="hidden" name="client_id" v-model="client_id">
                                                <?php echo Form::text('name',null,['class'=>'form-control client_name_autoCompleter','placeholder'=>'Name','autocomplete'=>"off",'required'=>'required']); ?>

                                            </div>
                                        </div>
                                        <label for="">Campaign Title</label>
                                        <div class="input-group">
                                            <span id="" class="input-group-addon">
                                                <i class="material-icons">person</i>
                                            </span>
                                            <div class="form-line autoCompleter" style="margin-bottom: 0px;">
                                                <?php echo Form::text('campaign_title',null,['class'=>'form-control','placeholder'=>'Name','autocomplete'=>"off",'required'=>'required']); ?>

                                            </div>
                                        </div>

                                        <label for="">Max Impression</label>
                                        <div class="input-group">
                                            <span id="" class="input-group-addon">
                                                <i class="material-icons">visibility</i>
                                            </span>
                                            <div class="form-line" style="margin-bottom: 0px;">
                                                <?php echo Form::text('total_impression',null,['class'=>'form-control','placeholder'=>'No of impression..']); ?>

                                            </div>
                                        </div>

                                        <label for="">Total Budget</label>
                                        <div class="input-group">
                                            <span id="" class="input-group-addon">
                                                <i class="material-icons">attach_money</i>
                                            </span>
                                            <div class="form-line" style="margin-bottom: 0px;">
                                                <?php echo Form::text('total_budget',null,['class'=>'form-control','placeholder'=>'Total budget..']); ?>

                                            </div>
                                        </div>
                                        <label for="">Remarks</label>
                                        <div class="input-group">
                                            <span id="" class="input-group-addon">
                                                <i class="material-icons">description</i>
                                            </span>
                                            <div class="form-line" style="margin-bottom: 0px;">
                                                <?php echo Form::textarea('remarks',null,['class'=>'form-control','placeholder'=>'Remarks','rows'=>'2','cols'=>'1']); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="submit" value="SAVE" class="btn btn-success btn-lg btn-block">
                                </div>

                            </div>
                           <div class="col-xs-6">
                                <div class="card">
                                    <div class="header">
                                        <h4 class="card-title">Manage Creative</h4>
                                    </div>
                                    <div class="body">
                                        <ul class="list-group" v-show="creatives.length>0">
                                            <li class="list-group-item" v-for="(row, index) in creatives">
                                                <input type="hidden" name="creative_title[]" v-model="row.creative_title">
                                                <input type="hidden" name="size[]" v-model="row.size">
                                                <input type="hidden" name="landing_url[]" v-model="row.landing_url">
                                                <h4 class="m-b-0" v-text="row.creative_title"></h4>
                                                <p class="m-b-0"><span class="font-13" v-text="row.size"></span> </p>
                                                <div class="input-group" style="margin-bottom: 0; margin-top:10px;">
                                                    <span id="" class="input-group-addon">
                                                        <i class="material-icons">file_upload</i>
                                                    </span>
                                                    <div class="" style="margin-bottom: 0px;">
                                                        <input type="file" class="btn btn-xs btn-info" name="creative_file[]" required />
                                                    </div>
                                                </div>
                                                <span @click="delete_creative_row(index)" style="position:absolute; top:5px; right:5px;" class="badge bg-pink btn btn-xs">x</span>
                                            </li>
                                        </ul>
                                        <button type="button" class="btn btn-block bg-blue-grey waves-effect" data-toggle="modal" data-target="#defaultModal"> <i class="material-icons">add</i> Add new creative</button>
                                    </div>
                                </div>
                           </div>
                            <?php echo Form::close(); ?>

                        </div>

                        <!-- Default Size -->
                        <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="defaultModalLabel">Creatives information</h4>
                                    </div>
                                    <div class="modal-body">
                                        <label for="">Title</label>
                                        <div class="input-group">
                                            <span id="" class="input-group-addon">
                                                <i class="material-icons">title</i>
                                            </span>
                                            <div class="form-line" style="margin-bottom: 0px;">
                                                <?php echo Form::text('creative_title[]',null,['class'=>'form-control','placeholder'=>'Creative name','autocomplete'=>"off",'v-model'=>'creative_title']); ?>

                                            </div>

                                        </div>
                                        <label for="">Dimension(width x height)</label>
                                        <div class="input-group">
                                            <span id="" class="input-group-addon">
                                                <i class="material-icons">crop_free</i>
                                            </span>
                                            <div class="form-line autoCompleter" style="margin-bottom: 0px;">
                                                <?php echo Form::text('size[]',null,['class'=>'form-control basicAutoComplete','placeholder'=>'Size','autocomplete'=>"off",'v-model'=>'size']); ?>

                                            </div>

                                        </div>

                                        <label for="">Landing URL</label>
                                        <div class="input-group">
                                            <span id="" class="input-group-addon">
                                                <i class="material-icons">link</i>
                                            </span>
                                            <div class="form-line" style="margin-bottom: 0px;">
                                                <?php echo Form::text('landing_url[]',null,['class'=>'form-control','placeholder'=>'example.com','autocomplete'=>"off",'v-model'=>'landing_url']); ?>

                                            </div>

                                        </div>
                                        <button type="button" class="btn bg-teal btn-block waves-effect" data-dismiss="modal" @click.prevent="add_creatives">ADD</button>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn bg-pink waves-effect" data-dismiss="modal">CLOSE</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



<?php $__env->stopSection(); ?>
<?php $__env->startSection('custom_page_style'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('custom_page_script'); ?>
    <script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.5/dist/latest/bootstrap-autocomplete.min.js"></script>

    <script type="text/javascript">

        let app = new Vue({
            el:'#app',
            data:{
                creatives:[],
                client_id:0,
                creative_title:'',
                size:'',
                started_at:'',
                ended_at:'',
                landing_url:'',
            },
            methods:{
                add_creatives:function(){
                    this.creatives.push({
                        creative_title:this.creative_title,
                        size:this.size,
                        landing_url:this.landing_url,
                        started_at:$('#started_at').val(),
                        ended_at:$('#ended_at').val(),
                    });
                    this.creative_title = '';
                    this.size = '';
                    this.landing_url = '';
                    this.started_at = '';
                    this.ended_at = '';
                },
                delete_creative_row:function(index){
                    this.creatives.splice(index, 1);
                },


            }
        });

        $('.client_name_autoCompleter').autoComplete({
            resolverSettings: {
                url: '<?php echo URL::to('get_clients'); ?>'
            },
            minLength:2,
            preventEnter:true
        }).on('autocomplete.select', function (evt, item) {
            console.log(item);
            app.client_id = item.value;
        }).on('autocomplete.freevalue',function(evt,value){
            $('bootstrap-autocomplete .disabled').remove();
            app.duplicate_company_name = false;
        }).on('focusout, blur',function(){
            $('bootstrap-autocomplete .disabled').remove();
        })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>