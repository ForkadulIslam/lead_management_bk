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
            <a href="{!! URL::to('module/lead') !!}" class="btn btn-xs btn-primary"> <i class="material-icons">add_circle_outline</i> Go to lead</a>
        </div>

        <!-- Striped Rows -->
        <div class="row clearfix" id="app">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="col-xs-6">
                                <h4>{!! $lead->name !!}</h4>
                                <p class="m-b-0">Contact: {!! $lead->phone !!} || Status: {!! $lead->calling_queue->calling_status !!}</p>
                                <p class="m-b-0 badge">
                                    <strong>Status</strong> : {!! $lead->calling_queue->calling_status !!}
                                    @if($lead->calling_queue->status_sub_type)
                                    / <small class="text-muted">{!! $lead->calling_queue->status_sub_type !!}</small>
                                    @endif
                                </p>
                            </div>
                            <div class="col-xs-6 text-right">
                                <p class="badge bg-pink">{!! $lead->calling_queue->user->full_name or 'N/A' !!} : Agent</p>
                                <p class="m-b-0">Call : {!! $lead->calling_queue()->where('status',1)->count() !!}</p>
                                <p class="m-b-0">Followup : {!! $lead->follow_up()->where('status',1)->count() !!}</p>
                                <p class="m-b-0">Remarks: {!! $lead->calling_queue->remarks !!}</p>
                            </div>
                        </div>
                    </div>
                    <div class="body table-responsive">
                        <div class="row clearfix">

                        </div>
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

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Striped Rows -->
    </div>
@endsection
@section('custom_page_script')
    <script type="text/javascript">



    </script>
@endsection


