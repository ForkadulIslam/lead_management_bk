@extends('admin.layouts.form')
@section('custom_page_style')
    <style>
        table td{
            vertical-align: middle!important;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <a href="{!! URL::to('module/client/contact_person_list') !!}">
                <strong>All contact person</strong>
            </a>
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
                    </div>
                    <div class="body table-responsive">
                        {!! Form::open(['url'=>URL::to('module/client/search_contact_person'),'method'=>'post']) !!}
                        <div class="row clearfix">

                            <div class="col-xs-6">
                                <div class="input-group" style="margin-bottom:0px;">
                                    <span class="input-group-addon">
                                        <i class="material-icons">perm_identity</i>
                                    </span>
                                    <div class="form-line">
                                        {!! Form::text('name',$request->name,['class'=>'form-control','placeholder'=>'Contact person name']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group">
                                    {!! Form::submit('SEARCH',['class'=>'btn btn-success btn-block']) !!}
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                        <table class="table table-striped table-bordered table-hover table-responsive">
                            <thead>
                            <tr>
                                <th style="width:250px;">Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Client name</th>
                                <th>Created by</th>
                                <th style="width:100px;">Option</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($contact_persons as $i=>$row)
                            <tr class="font-12">
                                <td style="width:250px;">
                                    <a href="{!! URL::to('module/client/contact_person_details',$row->id) !!}" data-toggle="tooltip" data-title="View member details">{!! $row->name !!}</a>
                                    <p class="margin-0">{!! $row->designation !!}, {!! $row->department !!}</p>
                                </td>
                                <td>
                                    <p class="margin-0">{!! $row->email !!}</p>
                                </td>
                                <td>
                                    <p class="margin-0">{!! $row->phone !!}</p>
                                </td>
                                <td>
                                    {!! $row->client->name or 'N/A' !!}
                                </td>
                                <td>
                                    {!! $row->creator->full_name or 'N/A' !!}
                                </td>
                                <td style="width:100px;">
                                    <a data-toggle="tooltip" data-title="Show details" class="btn btn-xs btn-info" href="{!! URL::to('module/client/contact_person_details',$row->id) !!}"><i class="material-icons">preview</i></a>
                                    <a data-toggle="tooltip" data-title="Edit" class="btn btn-xs btn-warning" href="{!! URL::to('module/client/edit_contact_person',$row->id) !!}"><i class="material-icons">edit</i></a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $contact_persons->appends($request->except(['_token']))->links() !!}
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
                //$('#table_form').submit();
            })
        })

    </script>
@endsection


