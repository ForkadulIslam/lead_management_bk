@extends('admin.layouts.form')
@section('custom_page_style')
    <style>
        .contact_person_created_by{
            position: absolute;
            bottom: 5px;
            right: 5px;
            font-size: 12px;
            font-style: italic;
            background: #dbdbdb;
            padding: 2px 10px;
            border-radius: 23px;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <a href="{!! URL::to('module/client') !!}" class="btn btn-sm btn-primary"> <i class="material-icons">list</i> Client lists</a>
            <a href="{!! URL::to('module/client/create') !!}" class="btn btn-sm btn-success"> <i class="material-icons">list</i> Create New Client</a>
            @if(Session::has('message'))
                <div class="alert alert-success alert-dismissible show" role="alert">
                    <strong>Congratulation</strong> {!! Session::get('message') !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
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
                            {!! Form::model($client,['url'=>URL::to('module/client',$client->id),'class'=>'form','files'=>'true','method'=>'patch']) !!}
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
                                                {!! Form::text('name',null,['class'=>'form-control client_name_autoCompleter','placeholder'=>'Name','autocomplete'=>"off",'required'=>'required']) !!}
                                            </div>
                                            <div v-if="duplicate_company_name" style="color:#a94442!important" class="help-info">This name already exist. Please try again with another name</div>
                                        </div>

                                        <label for="">Client Address</label>
                                        <div class="input-group">
                                            <span id="" class="input-group-addon">
                                                <i class="material-icons">home</i>
                                            </span>
                                            <div class="form-line" style="margin-bottom: 0px;">
                                                {!! Form::textarea('address',null,['class'=>'form-control','placeholder'=>'Address','rows'=>'2','cols'=>'1']) !!}
                                            </div>
                                        </div>

                                        <label for="">Industry</label>
                                        <div class="input-group">
                                            <span id="" class="input-group-addon">
                                                <i class="material-icons">store</i>
                                            </span>
                                            <div class="form-line" style="margin-bottom: 0px;">
                                                {!! Form::text('industry',null,['class'=>'form-control','placeholder'=>'Industry..']) !!}
                                            </div>
                                        </div>
                                        <label for="">Owner</label>
                                        <div class="input-group">
                                            {!! Form::select('executive_ids[]',\App\User::where('roll_id',2)->pluck('full_name','id'),$executive_ids,['class'=>'selectpicker','title'=>'--Executive--','multiple'=>'true']) !!}
                                        </div>

                                        @if($client->logo)
                                            <div class="input-group">
                                                <img src="{!! asset('public/uploads/'.$client->logo) !!}"
                                                     alt="Client logo" style="width:100px;height:100px;">
                                            </div>
                                        @endif
                                        <label for="">Logo</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">file_copy</i>
                                            </span>
                                            <div class="">
                                                {!! Form::file('file',['class'=>'btn btn-primary']) !!}
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
                                                <span @click="delete_contact_person_row(index,row.id)" style="position:absolute; top:5px; right:5px;" class="badge bg-pink btn btn-xs">x</span>
                                                <span v-if="row.created_by" class="contact_person_created_by" v-text="'Created by: '+row.created_by.full_name"></span>
                                            </li>
                                        </ul>
                                        <button type="button" class="btn btn-block bg-blue-grey waves-effect" data-toggle="modal" data-target="#defaultModal"> <i class="material-icons">add</i> Add Your Contact Person</button>
                                    </div>
                                </div>
                           </div>
                            {!! Form::close() !!}
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
                                                {!! Form::text('contact_person_name',null,['class'=>'form-control basicAutoComplete','placeholder'=>'Name','autocomplete'=>"off",'v-model'=>'name']) !!}
                                            </div>

                                        </div>
                                        <label for="">Email</label>
                                        <div class="input-group">
                                            <span id="" class="input-group-addon">
                                                <i class="material-icons">email</i>
                                            </span>
                                            <div class="form-line" style="margin-bottom: 0px;">
                                                {!! Form::text('contact_person_email',null,['class'=>'form-control','placeholder'=>'Email','v-model'=>'email']) !!}
                                            </div>
                                        </div>
                                        <label for="">Phone</label>
                                        <div class="input-group">
                                            <span id="" class="input-group-addon">
                                                <i class="material-icons">phone</i>
                                            </span>
                                            <div class="form-line" style="margin-bottom: 0px;">
                                                {!! Form::text('contact_person_phone',null,['class'=>'form-control','placeholder'=>'Phone..(Comma sepereted for multiple)','v-model'=>'phone']) !!}
                                            </div>
                                        </div>
                                        <label for="">Designation</label>
                                        <div class="input-group">
                                            <span id="" class="input-group-addon">
                                                <i class="material-icons">person</i>
                                            </span>
                                            <div class="form-line" style="margin-bottom: 0px;">
                                                {!! Form::text('contact_person_designation',null,['class'=>'form-control','placeholder'=>'Designation..','v-model'=>'designation']) !!}
                                            </div>
                                        </div>
                                        <label for="">Department</label>
                                        <div class="input-group">
                                            <span id="" class="input-group-addon">
                                                <i class="material-icons">home</i>
                                            </span>
                                            <div class="form-line" style="margin-bottom: 0px;">
                                                {!! Form::text('contact_person_department',null,['class'=>'form-control','placeholder'=>'Department..','v-model'=>'department']) !!}
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



@endsection
@section('custom_page_style')

@endsection
@section('custom_page_script')
    <script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.5/dist/latest/bootstrap-autocomplete.min.js"></script>

    <script type="text/javascript">

        let app = new Vue({
            el:'#app',
            data:{
                contact_persons:{!! $client->contact_persons !!},
                client_id:{!! $client->id !!},
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
                delete_contact_person_row:function(index,contact_person_id){
                    let _this = this;
                    is_confirm(function(){
                        _this.contact_persons.splice(index, 1);
                        axios.get('{!! URL::to('delete_contact_person') !!}/'+contact_person_id);
                        swal_close('Delete...');
                    },);
                }
            }
        });

        $('.client_name_autoCompleter').autoComplete({
            resolverSettings: {
                url: '{!! URL::to('get_clients') !!}'
            },
            minLength:2,
            preventEnter:true
        }).on('autocomplete.select', function (evt, item) {
            if(item.value !== app.client_id){
                $(this).val('');
                app.duplicate_company_name = true;
            }else{
                app.duplicate_company_name = false;
                $(this).val(item.text);
            }
        }).on('autocomplete.freevalue',function(evt,value){
            $('bootstrap-autocomplete .disabled').remove();
            app.duplicate_company_name = false;
        }).on('focusout, blur',function(){
            $('bootstrap-autocomplete .disabled').remove();
        })
    </script>
@endsection
