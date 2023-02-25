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
            <div class="row">
                <div class="col-xs-6">
                    <div class="info-box bg-pink hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">perm_identity</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL LEADS</div>
                            <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20">{!! $total_leads !!}</div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="info-box bg-light-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">perm_identity</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL QUEUE</div>
                            <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20">{!! $queue_leads !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-xs-12">
                <div class="card">
                    <div class="header bg-teal">
                        <div class="row clearfix">
                            <div class="col-xs-12">
                                <h5 class="">Activity summary of this month</h5>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-xs-12">
                                <table class="table table-bordered table-striped font-12">
                                    <thead>
                                    <tr>
                                        <th>Agent</th>
                                        @foreach(get_activity_list() as $activity)
                                            <th class="text-center">{!! $activity !!}</th>
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($executives as $executive)
                                        <tr>
                                            <td>{!! $executive->full_name !!}</td>
                                            @foreach(get_activity_list() as $key=>$value)
                                                <td class="text-center">{!! $executive->activities_of_this_month()->where('calling_status',$key)->count() !!}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
@section('custom_page_script')
    <script type="text/javascript">
        $(document).ready(function(){

        });
    </script>
@endsection