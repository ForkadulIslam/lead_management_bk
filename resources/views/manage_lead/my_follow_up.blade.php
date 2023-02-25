@extends('admin.layouts.form')
@section('custom_page_style')
    <style>
        table td{
            vertical-align: middle!important;
        }
        .timer_badge{
            font-size: 12px;
            display: block;
            padding: 3px 10px;
            background-color: #e6e6e6;
            line-height: 12px;
            margin: 0;
            font-weight: 900;
            text-align: center;
            border-radius: 15px;
            vertical-align: middle;
            color: #009877;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <a href="{!! URL::to('module/calling_queue/follow_ups') !!}"><strong>Follow ups</strong></a>
            @if(Session::has('message'))
                <div class="alert bg-teal alert-dismissible m-t-20 animated fadeInDownBig" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    {!! Session::get('message') !!}
                </div>
            @endif
            @if(Session::has('error_message'))
                <div class="alert bg-red alert-dismissible m-t-20 animated fadeInDownBig" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    {!! Session::get('error_message') !!}
                </div>
            @endif
        </div>

        <!-- Striped Rows -->
        <div class="row clearfix" id="app">
            <div class="col-xs-7">
                <div class="card">
                    <div class="header bg-pink">
                        <h4>Manage your follow-up leads</h4>
                    </div>
                    <div class="body table-responsive">
                        {!! Form::open(['url'=>'module/calling_queue/search_follow_up']) !!}
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">date_range</i>
                                    </span>
                                    <div class="form-line">
                                        {!! Form::text('from',request()->from ? request()->from : \Carbon\Carbon::now()->toDateString(),['placeholder'=>'From..', 'class'=>'form-control datepicker']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">date_range</i>
                                    </span>
                                    <div class="form-line">
                                        {!! Form::text('to',request()->to ? request()->to: \Carbon\Carbon::now()->toDateString(),['placeholder'=>'To..', 'class'=>'form-control datepicker']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group">
                                    <div class="form-line">
                                        {!! Form::select('status',['Switch Off'=>'Switch Off','No Answer'=>'No Answer','Interested'=>'Interested'],request()->status?request()->status:null,['placeholder'=>'--Status--', 'class'=>'selectpicker','data-width'=>'fit']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group">
                                    <div class="form-line">
                                        {!! Form::submit('SEARCh',['class'=>'btn btn-md btn-block btn-success',]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                        <table class="table table-bordered table-hover table-responsive">
                            <thead class="bg-success">
                            <tr>
                                <th style="width: 110px">Name</th>
                                <th style="width: 110px">Phone</th>
                                <th style="width: 110px">Date</th>
                                <th>Calling Status</th>
                                <th style="width:300px;">Remarks</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr @click="select_lead(item)" :class="item.is_selected ? 'font-12 bg-green' : 'font-12' " v-for="(item,index) in active_leads" :key="index">
                                <td>
                                    <span v-text="item.lead.name"></span>
                                </td>
                                <td v-text="item.lead.phone"></td>
                                <td v-text="item.follow_up_date"></td>
                                <td v-text="item.calling_queue.calling_status"></td>
                                <td style="width:100px;">
                                    <span v-text="item.remarks"></span>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="col-xs-5">
                <div class="card">
                    <div class="header bg-green clearfix">
                        <h4 class="pull-left">Calling section</h4>
                    </div>
                    <div class="body table-responsive" >
                        {!! Form::open(['url'=>url('module/calling_queue/create_from_follow_up_queue')]) !!}
                        <input type="hidden" name="queue_id" v-model="selected_lead.queue_id">
                        <input type="hidden" name="follow_up_id" v-model="selected_lead.follow_up_id">
                        <div  v-if="selected_lead.queue_id">
                            <label for="">Calling Status Type</label>
                            <div class="input-group" style="margin-bottom: 5px;">
                                <span class="input-group-addon">
                                    <i class="material-icons">file_copy</i>
                                </span>
                                <div class="form-group">
                                    {!! Form::select('calling_status',get_activity_list(),null,['class'=>'selectpicker','title'=>'--Status--','id'=>'calling_status_dropdown','v-model'=>'selected_lead.status','@change'=>'changeStatus']) !!}
                                </div>
                            </div>
                            <div v-if="selected_lead.status === 'Membership Sold'">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <label for="">Membership Category</label>
                                        <div class="input-group" style="margin-bottom: 0px;">
                                            <div class="form-group" style="margin-bottom: 0px;">
                                                {!! Form::select('membership_category',get_category(),null,['class'=>'selectpicker dropright','data-width'=>'fit' ,'title'=>'--Category--','id'=>'membership_category_dropdown','required'=>'required']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <label for="">Membership Duration</label>
                                        <div class="input-group" style="margin-bottom: 0px;">
                                            <div class="form-group" style="margin-bottom: 0px;">
                                                {!! Form::select('membership_duration',membership_duration(),null,['class'=>'selectpicker', 'data-width'=>'fit' ,'title'=>'--Duration--','id'=>'membership_duration_dropdown','required'=>'required']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-6">
                                        <label for="">Package Type</label>
                                        <div class="input-group" style="margin-bottom: 0px;">
                                            <div class="form-group" style="margin-bottom: 0px;">
                                                {!! Form::select('package_type',package_type(),null,['class'=>'selectpicker', 'data-width'=>'fit', 'title'=>'--Type--','required'=>'required']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <label for="">Location</label>
                                        <div class="input-group" style="margin-bottom: 0px;">
                                            <div class="form-group" style="margin-bottom: 0px;">
                                                {!! Form::select('membership_location',membership_location(),null,['class'=>'selectpicker', 'data-width'=>'fit', 'title'=>'--Location--','required'=>'required']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <label for="">Revenue</label>
                                <div class="input-group" style="margin-bottom: 5px;">
                                    <div class="form-group">
                                        {!! Form::text('revenue',null,['class'=>'form-control','required'=>'required', 'placeholder'=>'Revenue...']) !!}
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                <label for="">Status (<small class="text-muted">Sub type</small>)</label>
                                <div class="input-group">
                                    <div class="">
                                        <ul class="list-group" style="margin-bottom: 0;">
                                            <li style="padding:3px 8px;" class="list-group-item" v-for="(sub_type_item,index) in status_sub_type_lists" :key="index">
                                                <input v-model="selected_lead.status_sub_type" type="radio" name="status_sub_type" :id="'status_type_'+index" :value="sub_type_item">
                                                <label :for="'status_type_'+index">@{{ sub_type_item }}</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div v-if="selected_lead.status === 'Switch Off' || selected_lead.status === 'No Answer' || selected_lead.status === 'Interested'">
                                <label for="">Follow-up Date (*)</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">date_range</i>
                                    </span>
                                    <div class="form-line">
                                        <vuejs-datepicker name="follow_up_date" v-model="follow_up_date" format="yyyy-MM-dd"></vuejs-datepicker>
                                    </div>
                                    <div class="form-error" v-if="show_date_error">
                                        <span class="text-danger">Date filed is required</span>
                                    </div>
                                </div>
                            </div>
                            <label for="">Remarks</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">format_size</i>
                                </span>
                                <div class="form-line">
                                    {!! Form::textarea('remarks',null,['placeholder'=>'Remarks','rows'=>2,'class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="input-group" style="margin-bottom: 0">
                                {!! Form::submit('SAVE',['class'=>'btn btn-success btn-block btn-md']) !!}
                            </div>
                        </div>
                        <div v-else>
                            <p class="text-muted text-center">Please select a lead first from the left side</p>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>



        </div>
        <!-- #END# Striped Rows -->


    </div>

@endsection
@section('custom_page_script')
    <script src="https://unpkg.com/vuejs-datepicker"></script>
    <script type="text/javascript">

        let app = new Vue({
            el:'#app',
            components: {
                vuejsDatepicker
            },
            data:{
                active_leads:{!! $follow_ups !!},
                selected_lead:{
                    follow_up_id:null,
                    queue_id:null,
                    status:null,
                    status_sub_type:null,
                    remarks:null
                },
                status_sub_type_lists:[],
            },
            created(){

            },
            methods:{
                select_lead:function (_item) {
                    console.log(_item);
                    this.selected_lead = {};
                    this.status_sub_type_lists = []
                    this.active_leads.map(function(item){
                        if(item.id === _item.id){
                            item.is_selected = true;
                        }else{
                            item.is_selected = false
                        }
                    });
                    this.selected_lead = {
                        follow_up_id: _item.id,
                        queue_id : _item.queue_id,
                        status:null,
                        status_sub_type: null,
                        remarks:_item.remarks,
                    }
                    setTimeout(function(){
                        $('#calling_status_dropdown').selectpicker('refresh');
                    },300);
                },
                changeStatus:function () {
                    if(this.selected_lead.status === 'Informative'){
                        this.status_sub_type_lists = ['Membership package','Ad posting','About Bikroy','Existing Member']
                    }else if(this.selected_lead.status === 'Uncontactable'){
                        this.status_sub_type_lists = ['Uncontactable']
                    }else if(this.selected_lead.status === 'Interested'){
                        this.status_sub_type_lists = ['Low','Medium','High']
                    }else if(this.selected_lead.status === 'Not Interested'){
                        this.status_sub_type_lists = ['Product Shortage','Higher Membership Price','No Business']
                    }else if(this.selected_lead.status === 'Membership Sold'){
                        setTimeout(function(){
                            $('.selectpicker').selectpicker('refresh')
                        },300);
                    }else if(this.selected_lead.status === 'Switch Off'){
                        this.status_sub_type_lists = ['Switch Off']
                    }else if(this.selected_lead.status === 'No Answer'){
                        this.status_sub_type_lists = ['No Answer']
                    }
                    else{
                        this.status_sub_type_lists = ['Membership Sold','Duplicate Leads','Lead Transfer to BDM']
                    }
                }
            }
        });
    </script>
    <script type="text/javascript">

    </script>
@endsection


