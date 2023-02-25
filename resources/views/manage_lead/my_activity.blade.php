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
            <a href="{!! URL::to('module/calling_queue') !!}"><strong>Reload</strong></a>
        </div>

        <!-- Striped Rows -->
        <div class="row clearfix" id="app">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <a href="{!! URL::to('module/calling_queue/create') !!}" class="btn btn-xs btn-primary"> <i class="material-icons">add_circle_outline</i> Go to queue</a>
                    </div>
                    <div class="body table-responsive">
                        {!! Form::open(['url'=>URL::to('module/calling_queue/search'),'method'=>'post']) !!}
                        <div class="row clearfix">

                            <div class="col-xs-3">
                                <div class="input-group" style="margin-bottom:0px;">
                                    <span class="input-group-addon">
                                        <i class="material-icons">perm_identity</i>
                                    </span>
                                    <div class="form-line">
                                        {!! Form::text('from',request()->from ? request()->from : \Carbon\Carbon::now()->toDateString(),['class'=>'form-control datepicker', 'placeholder'=>'From..']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group" style="margin-bottom:0px;">
                                    <span class="input-group-addon">
                                        <i class="material-icons">perm_identity</i>
                                    </span>
                                    <div class="form-line">
                                        {!! Form::text('to',request()->to ? request()->to : \Carbon\Carbon::now()->toDateString(),['class'=>'form-control datepicker', 'placeholder'=>'To..']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">file_copy</i>
                                    </span>
                                    <div class="">
                                        {!! Form::select('calling_status',get_activity_list(),request()->calling_status ? request()->calling_status : null,['class'=>'selectpicker','title'=>'--Status--','data-width'=>'100%','placeholder'=>'--Status--']) !!}
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
                        <p>TOTAL LEAD: {!! $queue->count(); !!}</p>
                        <table class="table table-striped table-bordered table-hover table-responsive">
                            <thead class="bg-teal">
                            <tr>
                                <th style="width:60px;">SL</th>
                                <th style="width: 150px">Name</th>
                                <th style="width: 100px">Phone</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Remarks</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($queue as $i=>$lead)
                            <tr class="font-12">
                                <td style="width:50px;">{!! ($i+1) !!}</td>
                                <td>{!! $lead->lead->name !!}</td>
                                <td>{!! $lead->lead->phone !!}</td>
                                <td>{!! $lead->lead->category !!}</td>
                                <td>
                                    {!! $lead->calling_status !!}
                                    @if($lead->status_sub_type)
                                    / <small>{!! $lead->status_sub_type !!}</small>
                                    @endif
                                </td>
                                <th>
                                    {!! $lead->remarks !!}
                                </th>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $queue->appends(request()->except(['_token']))->links() !!}
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


