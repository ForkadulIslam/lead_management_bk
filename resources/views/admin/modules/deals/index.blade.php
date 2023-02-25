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
            <a href="{!! URL::to('module/deals') !!}"><strong>List of deal</strong></a>
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
                        <a href="{!! URL::to('module/deals/create') !!}" class="btn btn-xs btn-primary"> <i class="material-icons">add_circle_outline</i> Create new deal</a>
                    </div>
                    <div class="body table-responsive">
                        {!! Form::open(['url'=>URL::to('module/deals/search'),'method'=>'post']) !!}
                        <div class="row clearfix">

                            <div class="col-xs-3">
                                <div class="input-group" style="margin-bottom:0px;">
                                    <span class="input-group-addon">
                                        <i class="material-icons">perm_identity</i>
                                    </span>
                                    <div class="form-line">
                                        {!! Form::text('client_name',$request->client_name ? $request->client_name : null,['class'=>'form-control','placeholder'=>'Client name']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group" style="margin-bottom:0px;">
                                    <span class="input-group-addon">
                                        <i class="material-icons">perm_identity</i>
                                    </span>
                                    <div class="form-line">
                                        {!! Form::select('executive_id',\App\User::where('roll_id',2)->pluck('full_name','id'),$request->executive_id ? $request->executive_id : null,['class'=>'form-control selectpicker','placeholder'=>'--Executive--']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">file_copy</i>
                                    </span>
                                    <div class="">
                                        {!! Form::select('stage',get_deals_stage(),$request->stage ? $request->stage : null,['class'=>'selectpicker','title'=>'--Stage--','data-width'=>'fit','placeholder'=>'--Stage--']) !!}
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
                        {!! Form::open(['url'=>URL::to('module/member/table_action'),'id'=>'table_form']) !!}
                        <p>TOTAL DEALS: {!! $data->total(); !!}</p>
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
                                <th style="width:100px;">Option</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $i=>$row)
                            <tr class="font-12">
                                <td style="width:250px;">
                                    @php
                                    $title = [];
                                    foreach ($row->contactPersons as $contactPerson){
                                        $title[] = $contactPerson->name;
                                    }
                                    @endphp
                                    <a href="{!! URL::to('module/deals',$row->id) !!}" data-toggle="tooltip" data-title="{!! implode(',',$title) !!}">{!! $row->title !!}</a>
                                    <p class="m-b-0 font-11 font-italic">{!! $row->client->name or 'N/A' !!}</p>
                                </td>
                                <td>
                                    @foreach($row->executives as $executive)
                                        <p class="m-b-0"> - {!! $executive->full_name !!}</p>
                                    @endforeach
                                </td>
                                <td>
                                    <p class="m-b-0">{!! $row->creation_date !!}</p>
                                    <small class="font-bold text-success">
                                        @php
                                            $start_time = \Carbon\Carbon::createFromFormat('Y-m-d',$row->creation_date);
                                            $diff = $start_time->diffForHumans(\Carbon\Carbon::now());
                                        @endphp
                                        {!! $diff !!}
                                    </small>
                                </td>
                                <td>
                                    <p>{!! $row->closing_date !!}</p>
                                </td>
                                <td>
                                    <p>{!! $row->amount !!} TK</p>
                                </td>
                                <td>
                                    <p>{!! $row->stage !!}</p>
                                </td>
                                <td style="width:100px;">
                                    <a data-toggle="tooltip" data-title="Edit" class="btn btn-xs btn-warning" href="{!! URL::to('module/deals/'.$row->id,'edit') !!}"><i class="material-icons">edit</i></a>
                                    <a data-toggle="tooltip" data-title="Delete" class="btn btn-xs btn-danger delete_with_swal" href="{!! URL::to('module/deals',$row->id) !!}"><i class="material-icons">remove</i></a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {!! Form::close() !!}
                        {!! $data->appends($request->except(['_token']))->links() !!}
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
            $('.delete_with_swal').click(function(e){
                e.preventDefault();
                delete_with_swal($(this).attr('href'),'{!! csrf_token() !!}',$(this).closest('tr'));
            })
        })

    </script>
@endsection


