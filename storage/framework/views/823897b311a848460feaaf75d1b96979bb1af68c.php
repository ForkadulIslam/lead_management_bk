
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="block-header">
            <a href="<?php echo URL::to('module/client'); ?>" class="btn btn-sm btn-primary"> <i class="material-icons">list</i> Client lists</a>
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
                            Create new client
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
                            <?php echo Form::open(['url'=>URL::to('module/client'),'class'=>'form','files'=>'true']); ?>

                            <div class="col-xs-6">
                                <div class="card">
                                    <div class="header">
                                        <h4 class="card-title">Client information</h4>
                                    </div>
                                    <div class="body">
                                        <label for="">Client name</label>
                                        <div class="input-group">
                                            <span id="" class="input-group-addon">
                                                <i class="material-icons">person</i>
                                            </span>
                                            <div :class="duplicate_company_name ? 'form-line autoCompleter focused error':'form-line autoCompleter'" style="margin-bottom: 0px;">
                                                <?php echo Form::text('name',null,['class'=>'form-control client_name_autoCompleter','placeholder'=>'Name','autocomplete'=>"off",'required'=>'required']); ?>

                                            </div>
                                            <div v-if="duplicate_company_name" style="color:#a94442!important" class="help-info">This name already exist. Please try again with another name</div>
                                        </div>

                                        <label for="">Client Address</label>
                                        <div class="input-group">
                                            <span id="" class="input-group-addon">
                                                <i class="material-icons">home</i>
                                            </span>
                                            <div class="form-line" style="margin-bottom: 0px;">
                                                <?php echo Form::textarea('address',null,['class'=>'form-control','placeholder'=>'Address','rows'=>'2','cols'=>'1']); ?>

                                            </div>
                                        </div>

                                        <label for="">Industry</label>
                                        <div class="input-group">
                                            <span id="" class="input-group-addon">
                                                <i class="material-icons">store</i>
                                            </span>
                                            <div class="form-line" style="margin-bottom: 0px;">
                                                <?php echo Form::text('industry',null,['class'=>'form-control','placeholder'=>'Industry..']); ?>

                                            </div>
                                        </div>

                                        <label for="">Owner</label>
                                        <div class="input-group">
                                            <?php echo Form::select('executive_ids[]',\App\User::where('roll_id',2)->pluck('full_name','id'),[auth()->user()->id],['class'=>'selectpicker','title'=>'--Executive--','multiple'=>'true']); ?>

                                        </div>

                                        <label for="">Logo</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">file_copy</i>
                                            </span>
                                            <div class="">
                                                <?php echo Form::file('file',['class'=>'btn btn-primary']); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="submit" value="SAVE" class="btn btn-success btn-lg">
                                </div>

                            </div>
                           <div class="col-xs-6">
                                <div class="card">
                                    <div class="header">
                                        <h4 class="card-title">Contact person</h4>
                                    </div>
                                    <div class="body">
                                        <ul class="list-group" v-show="contact_persons.length>0">
                                            <li class="list-group-item" v-for="(row, index) in contact_persons">
                                                <input type="hidden" name="c_id[]" v-model="row.id">
                                                <input type="hidden" name="c_name[]" v-model="row.name">
                                                <input type="hidden" name="c_designation[]" v-model="row.designation">
                                                <input type="hidden" name="c_department[]" v-model="row.department">
                                                <input type="hidden" name="c_phone[]" v-model="row.phone">
                                                <input type="hidden" name="c_email[]" v-model="row.email">
                                                <h4 class="m-b-0" v-text="row.name"></h4>
                                                <p class="m-b-0"><span class="font-15" style="font-weight: 700;" v-text="row.designation"></span>, <span class="font-13" v-text="'Department: '+row.department"></span> </p>
                                                <p class="m-b-0"><span v-text="row.phone"></span> || <span v-text="row.email"></span></p>
                                                <span @click="delete_contact_person_row(index)" style="position:absolute; top:5px; right:5px;" class="badge bg-pink btn btn-xs">x</span>
                                            </li>
                                        </ul>
                                        <button type="button" class="btn btn-block bg-blue-grey waves-effect" data-toggle="modal" data-target="#defaultModal"> <i class="material-icons">add</i> Add Your Contact Person</button>
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
                                        <h4 class="modal-title" id="defaultModalLabel">Add your new contact person for this client</h4>
                                    </div>
                                    <div class="modal-body">
                                        <label for="">Name</label>
                                        <div class="input-group">
                                            <span id="" class="input-group-addon">
                                                <i class="material-icons">person</i>
                                            </span>
                                            <div class="form-line autoCompleter" style="margin-bottom: 0px;">
                                                <?php echo Form::text('contact_person_name',null,['class'=>'form-control basicAutoComplete','placeholder'=>'Name','autocomplete'=>"off",'v-model'=>'name']); ?>

                                            </div>

                                        </div>
                                        <label for="">Email</label>
                                        <div class="input-group">
                                            <span id="" class="input-group-addon">
                                                <i class="material-icons">email</i>
                                            </span>
                                            <div class="form-line" style="margin-bottom: 0px;">
                                                <?php echo Form::text('contact_person_email',null,['class'=>'form-control','placeholder'=>'Email','v-model'=>'email']); ?>

                                            </div>
                                        </div>
                                        <label for="">Phone</label>
                                        <div class="input-group">
                                            <span id="" class="input-group-addon">
                                                <i class="material-icons">phone</i>
                                            </span>
                                            <div class="form-line" style="margin-bottom: 0px;">
                                                <?php echo Form::text('contact_person_phone',null,['class'=>'form-control','placeholder'=>'Phone..(Comma sepereted for multiple)','v-model'=>'phone']); ?>

                                            </div>
                                        </div>
                                        <label for="">Designation</label>
                                        <div class="input-group">
                                            <span id="" class="input-group-addon">
                                                <i class="material-icons">person</i>
                                            </span>
                                            <div class="form-line" style="margin-bottom: 0px;">
                                                <?php echo Form::text('contact_person_designation',null,['class'=>'form-control','placeholder'=>'Designation..','v-model'=>'designation']); ?>

                                            </div>
                                        </div>
                                        <label for="">Department</label>
                                        <div class="input-group">
                                            <span id="" class="input-group-addon">
                                                <i class="material-icons">home</i>
                                            </span>
                                            <div class="form-line" style="margin-bottom: 0px;">
                                                <?php echo Form::text('contact_person_department',null,['class'=>'form-control','placeholder'=>'Department..','v-model'=>'department']); ?>

                                            </div>
                                        </div>
                                        <button type="button" class="btn bg-teal btn-block waves-effect" data-dismiss="modal" @click.prevent="add_contact_person">ADD</button>
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
                contact_persons:[],
                id:0,
                name:'',
                email:'',
                phone:'',
                designation:'',
                department:'',
                duplicate_company_name:false,
            },
            methods:{
                add_contact_person:function(){
                    this.contact_persons.push({
                        id:this.id,
                        name:this.name,
                        email:this.email,
                        phone:this.phone,
                        designation:this.designation,
                        department:this.department,
                    });
                    this.clear_contact_person_field();
                },
                clear_contact_person_field:function(){
                    this.id=0,
                    this.name = '';
                    this.email = '';
                    this.phone = '';
                    this.designation = '';
                    this.department = '';
                },
                delete_contact_person_row:function(index){
                    this.contact_persons.splice(index, 1);
                }
            }
        });

        $('.client_name_autoCompleter').autoComplete({
            resolverSettings: {
                url: '<?php echo URL::to('get_clients'); ?>'
            },
            minLength:2,
            preventEnter:true
        }).on('autocomplete.select', function (evt, item) {
            $(this).val('');
            app.duplicate_company_name = true;
        }).on('autocomplete.freevalue',function(evt,value){
            $('bootstrap-autocomplete .disabled').remove();
            app.duplicate_company_name = false;
        }).on('focusout, blur',function(){
            $('bootstrap-autocomplete .disabled').remove();
        })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>