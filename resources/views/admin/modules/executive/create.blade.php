@extends('admin.layouts.form')
@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <a href="{!! URL::to('module/executive') !!}" class="btn btn-sm btn-primary"> <i class="material-icons">list</i> Agent lists</a>
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
                            Create new agent
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
                            {!! Form::open(['url'=>URL::to('module/executive'),'class'=>'form','files'=>'true']) !!}
                            <div class="col-xs-6">
                                <label for="">Name</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">person</i>
                                    </span>
                                    <div class="form-line">
                                        {!! Form::text('full_name',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <label for="">Phone</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">phone</i>
                                    </span>
                                    <div class="form-line">
                                        {!! Form::text('phone',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <label for="">Login ID</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">person</i>
                                    </span>
                                    <div class="form-line">
                                        {!! Form::text('email',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <label for="">Password</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">lock</i>
                                    </span>
                                    <div class="form-line">
                                        {!! Form::password('password',['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="submit" value="CREATE" class="btn btn-success btn-md btn-block">
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- #END# Color Pickers -->

    </div>
@endsection
@section('custom_page_script')
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
@endsection
