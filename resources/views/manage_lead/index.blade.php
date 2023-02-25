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
            <a href="{!! URL::to('module/lead') !!}"><strong>Reload</strong></a>
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
                        <a href="{!! URL::to('module/lead/create') !!}" class="btn btn-xs btn-primary"> <i class="material-icons">add_circle_outline</i> Import leads</a>
                    </div>
                    <div class="body table-responsive">
                        {!! Form::open(['url'=>URL::to('module/member/table_action'),'id'=>'table_form']) !!}
                        <p>TOTAL LEAD: {!! $leads->total(); !!}</p>
                        <table class="table table-striped table-bordered table-hover table-responsive">
                            <thead class="bg-teal">
                            <tr>
                                <th style="width:60px;">SL</th>
                                <th style="width: 150px">Name</th>
                                <th style="width: 100px">Phone</th>
                                <th style="width:101px;">Source</th>
                                <th style="width:101px;">Category</th>
                                <th style="width:100px;">Agent</th>
                                <th style="width: 85px" class="text-center">No of attempt</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($leads as $i=>$lead)
                            <tr class="font-12">
                                <td style="width:50px;">{!! ($i+1) !!}</td>
                                <td>{!! $lead->name !!}</td>
                                <td>{!! $lead->phone !!}</td>
                                <td>{!! $lead->source !!}</td>
                                <td>{!! $lead->category !!}</td>
                                <td style="width:100px;">
                                    {!! $lead->calling_queue->user->full_name or 'N/A' !!}
                                </td>
                                <td class="text-center">
                                    <a href="{!! url('module/lead/activity_details',$lead->id) !!}">
                                        <span class="badge bg-pink">{!! $lead->no_of_attempts !!}</span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {!! Form::close() !!}
                        {!! $leads->appends(request()->except(['_token']))->links() !!}
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


