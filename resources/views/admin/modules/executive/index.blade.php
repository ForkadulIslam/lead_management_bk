@extends('admin.layouts.form')
@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <strong>Agent lists</strong>
            @if(Session::has('message'))
                <div class="alert bg-teal alert-dismissible m-t-20 animated fadeInDownBig" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    {!! Session::get('message') !!}
                </div>
            @endif
        </div>

        <!-- Striped Rows -->
        <div class="row clearfix" id="app">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <a href="{!! URL::to('module/executive/create') !!}" class="btn btn-xs btn-primary"> <i class="material-icons">add_circle_outline</i> Create New Agent</a>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a id="executive_allocation" href="javascript:void(0);">Delete multiple</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body table-responsive">

                        {!! Form::open(['url'=>URL::to('module/executive/table_action'),'id'=>'table_form']) !!}
                        <table class="table table-striped table-bordered table-hover table-responsive">
                            <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="select_all" class="filled-in" />
                                    <label for="select_all"></label>
                                </th>
                                <th style="width:250px;">Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th style="width:100px;">Option</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($executives as $i=>$executive)
                            <tr>
                                <td>
                                    <input name="member_id[]" type="checkbox" value="{!! $executive->id !!}" id="member_id_{!! $executive->id !!}" class="filled-in" />
                                    <label for="member_id_{!! $executive->id !!}"></label>
                                </td>
                                <td style="width:250px;">{!! $executive->full_name !!}</td>
                                <td>{!! $executive->email !!}</td>
                                <td>{!! $executive->phone !!}</td>
                                <td style="width:100px;">
                                    <a data-toggle="tooltip" data-title="Edit" class="btn btn-xs btn-warning" href="{!! URL::to('module/executive/'.$executive->id,'edit') !!}"><i class="material-icons">edit</i></a>
                                    <a data-toggle="tooltip" data-title="Delete" class="btn btn-xs btn-danger delete_with_swal" href="{!! URL::to('module/executive',$executive->id) !!}"><i class="material-icons">remove</i></a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! Form::close() !!}
                        {!! $executives->appends($request->except(['_token']))->links() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Striped Rows -->
    </div>
@endsection
@section('custom_page_script')
    <script type="text/javascript">

        $(document).ready(function(){
            $('#select_all').change(function() {
                $('[name="member_id[]"]').click();
            });
            $('#executive_allocation').click(function(e){
                e.preventDefault();
                $('#table_form').submit();
            })

        })

    </script>
@endsection