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
                            <div class="text">TOTAL ACTIVE DEAL</div>
                            <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20">{!! $total_active_deals !!}</div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="info-box bg-light-green hover-expand-effect">
                        <div class="icon">
                            <i>৳</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL DEALS VALUE</div>
                            <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20">{!! $total_invoice_amount !!} TK</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-6">
                <div class="card">
                    <div class="header bg-teal">
                        <div class="row clearfix">
                            <div class="col-xs-12">
                                <h5 class="">Activity summary</h5>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-xs-12">
                                <table class="table table-bordered table-striped font-12">
                                    <thead>
                                        <tr>
                                            <th>Activity</th>
                                            <th class="text-center">This Month</th>
                                            <th class="text-center">Cumulative</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Meeting</td>
                                        <td class="text-center">{!! $meeting['this_month'] !!}</td>
                                        <td class="text-center">{!! $meeting['cumulative'] !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Proposal Share</td>
                                        <td class="text-center">{!! $proposal_share['this_month'] !!}</td>
                                        <td class="text-center">{!! $proposal_share['cumulative'] !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Followup Call</td>
                                        <td class="text-center">{!! $call['this_month'] !!}</td>
                                        <td class="text-center">{!! $call['cumulative'] !!}</td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <a href="{!! URL::to('module/activity') !!}">Show more</a>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="card">
                    <div class="header bg-teal">
                        <div class="row clearfix">
                            <div class="col-xs-12">
                                <h5 class="">Upcoming activity</h5>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-xs-12">
                                <table class="table talbe-responsive table-striped table-bordered table-hovered text-left font-12">
                                    <tbody>
                                    @foreach($upcoming_activity as $row)
                                        <tr>
                                            <td>
                                                <p class="m-b-0 font-14">{!! $row->title !!}</p>
                                            </td>
                                            <td>
                                                <p>{!! $row->start_time !!}</p>
                                            </td>
                                            <td>
                                                @if($row->linked_with == 1)
                                                    <strong>{!! $row->client->name or 'N/A' !!}</strong>
                                                    @foreach($row->contact_persons as $contact_person)
                                                        <p class="m-b-0"> - {!! $contact_person->name !!} &nbsp; <small>({!! $contact_person->phone !!})</small></p>
                                                    @endforeach
                                                @endif
                                                @if($row->linked_with == 2)
                                                    <strong>{!! $row->deal->title or 'N/A' !!}</strong>
                                                    @foreach($row->contact_persons as $contact_person)
                                                        <p class="m-b-0"> - {!! $contact_person->name !!} &nbsp; <small>({!! $contact_person->phone !!})</small></p>
                                                    @endforeach
                                                @endif
                                                @if($row->linked_with == 3)
                                                    <strong>{!! $row->individual_contact_person->name or 'N/A' !!} </strong> <small>({!! $row->individual_contact_person->phone !!})</small>
                                                    <p class="m-b-0"> - {!! $row->individual_contact_person->client->name or 'N/A' !!}</p>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <a href="{!! URL::to('module/activity') !!}">Show more</a>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
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
                                <h5 class="">Lost Deals</h5>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-xs-12">
                                <p>TOTAL LOST DEALS: {!! $lost_deal->total(); !!}</p>
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
                                    @foreach($lost_deal as $i=>$row)
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
            $('.datepicker').bootstrapMaterialDatePicker({
                format: 'YYYY-MM-DD',
                clearButton: true,
                weekStart: 1,
                time: false
            });
        });
    </script>
@endsection