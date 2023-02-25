@extends('admin.layouts.form')
@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <a href="{!! URL::to('module/lead') !!}" class="btn btn-sm btn-primary"> <i class="material-icons">list</i> Leads bucket</a>
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
                            Upload
                        </h2>
                    </div>
                    <div class="body" id="app">
                        <div class="row clearfix">
                            {!! Form::open(['url'=>URL::to('module/lead/store'),'class'=>'form','files'=>'true']) !!}
                            <div class="col-xs-6">
                                <label for="">EXCEL/CSV</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">attach_file</i>
                                    </span>
                                    <div class="form-line">
                                        {!! Form::file('file',['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="submit" value="IMPORT" class="btn btn-success btn-md btn-block">
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
