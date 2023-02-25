<?php $__env->startSection('custom_page_style'); ?>
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="block-header">
            <a href="<?php echo URL::to('module/lead'); ?>"><strong>Lead bucket</strong></a>
            <?php if(Session::has('message')): ?>
                <div class="alert bg-teal alert-dismissible m-t-20 animated fadeInDownBig" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <?php echo Session::get('message'); ?>

                </div>
            <?php endif; ?>
            <?php if(Session::has('error_message')): ?>
                <div class="alert bg-red alert-dismissible m-t-20 animated fadeInDownBig" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <?php echo Session::get('error_message'); ?>

                </div>
            <?php endif; ?>
        </div>

        <!-- Striped Rows -->
        <div class="row clearfix" id="app">
            <div class="col-xs-7">
                <div class="card">
                    <div class="header bg-pink">
                        <h4>Manage your lead</h4>
                    </div>
                    <div class="body table-responsive">

                        <p>ACTIVE LEADS: <?php echo $active_leads->count();; ?></p>
                        <table class="table table-bordered table-hover table-responsive">
                            <thead class="bg-success">
                            <tr>
                                <th style="width: 150px">Name</th>
                                <th style="width: 100px">Phone</th>
                                <th style="width:101px;">Source</th>
                                <th style="width:101px;">Category</th>
                                <th style="width:100px;">Option</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr :class="item.is_selected ? 'font-12 bg-green' : 'font-12' " v-for="(item,index) in active_leads" :key="index">
                                <td>
                                    <span v-text="item.lead.name"></span> <span class="timer_badge">{{ item.remaining_minutes }}</span>
                                </td>
                                <td v-text="item.lead.phone"></td>
                                <td v-text="item.lead.source"></td>
                                <td v-text="item.lead.category"></td>
                                <td style="width:100px;">
                                    <span class="btn btn-xs btn-success" @click.prevent="select_lead(item)">Select</span>
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
                        <?php echo Form::open(['url'=>url('module/calling_queue'),'ref'=>'form','@submit.prevent'=>'onSubmit']); ?>

                        <input type="hidden" name="queue_id" v-model="selected_lead.queue_id">
                        <div  v-if="selected_lead.queue_id">
                            <label for="">Calling Status Type</label>
                            <div class="input-group" style="margin-bottom: 5px;">
                                <span class="input-group-addon">
                                    <i class="material-icons">file_copy</i>
                                </span>
                                <div class="form-group">
                                    <?php echo Form::select('calling_status',get_activity_list(),null,['class'=>'selectpicker','title'=>'--Status--','id'=>'calling_status_dropdown','v-model'=>'selected_lead.status','@change'=>'changeStatus']); ?>

                                </div>
                            </div>
                            <div v-if="selected_lead.status === 'Membership Sold'">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <label for="">Membership Category</label>
                                        <div class="input-group" style="margin-bottom: 0px;">
                                            <div class="form-group" style="margin-bottom: 0px;">
                                                <?php echo Form::select('membership_category',get_category(),null,['class'=>'selectpicker dropright','data-width'=>'fit' ,'title'=>'--Category--','id'=>'membership_category_dropdown','required'=>'required']); ?>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <label for="">Membership Duration</label>
                                        <div class="input-group" style="margin-bottom: 0px;">
                                            <div class="form-group" style="margin-bottom: 0px;">
                                                <?php echo Form::select('membership_duration',membership_duration(),null,['class'=>'selectpicker', 'data-width'=>'fit' ,'title'=>'--Duration--','id'=>'membership_duration_dropdown','required'=>'required']); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-6">
                                        <label for="">Package Type</label>
                                        <div class="input-group" style="margin-bottom: 0px;">
                                            <div class="form-group" style="margin-bottom: 0px;">
                                                <?php echo Form::select('package_type',package_type(),null,['class'=>'selectpicker', 'data-width'=>'fit', 'title'=>'--Type--','required'=>'required']); ?>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <label for="">Location</label>
                                        <div class="input-group" style="margin-bottom: 0px;">
                                            <div class="form-group" style="margin-bottom: 0px;">
                                                <?php echo Form::select('membership_location',membership_location(),null,['class'=>'selectpicker', 'data-width'=>'fit', 'title'=>'--Location--','required'=>'required']); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <label for="">Revenue</label>
                                <div class="input-group" style="margin-bottom: 5px;">
                                    <div class="form-group">
                                        <?php echo Form::text('revenue',null,['class'=>'form-control','required'=>'required', 'placeholder'=>'Revenue...']); ?>

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
                                                <label :for="'status_type_'+index">{{ sub_type_item }}</label>
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
                                    <?php echo Form::textarea('remarks',null,['placeholder'=>'Remarks','rows'=>2,'class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="input-group" style="margin-bottom: 0">
                                <?php echo Form::submit('SAVE',['class'=>'btn btn-success btn-block btn-md']); ?>

                            </div>
                        </div>
                        <div v-else>
                            <p class="text-muted text-center">Please select a lead first from the left side</p>
                        </div>
                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>


        </div>
        <!-- #END# Striped Rows -->


    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('custom_page_script'); ?>
    <script src="https://unpkg.com/vuejs-datepicker"></script>
    <script type="text/javascript">

        let app = new Vue({
            el:'#app',
            components: {
                vuejsDatepicker
            },
            data:{
                follow_up_date:null,
                show_date_error:false,
                active_leads:<?php echo $active_leads; ?>,
                selected_lead:{
                    queue_id:null,
                    status:null,
                    status_sub_type:null,
                    remarks:null,
                },
                status_sub_type_lists:[],
            },
            created(){
                for(let i=0; i<this.active_leads.length;i++){
                    this.remainingTimeIndicator(this.active_leads[i])
                }
            },
            methods:{
                onSubmit() {
                    this.show_date_error = false;
                    if(this.selected_lead.status === 'Switch Off' || this.selected_lead.status === 'Uncontactable'){
                        if (this.follow_up_date !== null) {
                            this.$refs.form.submit();
                        } else {
                            this.show_date_error = true
                        }
                    }else{
                        this.$refs.form.submit();
                    }
                },
                remainingTimeIndicator(_obj){
                    const countDownDate = _obj.str_to_time + 1800000; // 5 minutes = 300000 milliseconds

                    // Update the count down every 1 second
                    const x = setInterval(function() {
                        const now = new Date().getTime();
                        const distance = countDownDate - now;
                        const minutes = Math.floor(distance / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                        _obj.remaining_minutes = minutes+':'+seconds
                        if (distance < 0) {
                            _obj.remaining_minutes = 'Returned'
                            clearInterval(x);
                            //document.getElementById("timer").innerHTML = "EXPIRED";
                        }
                    }, 1000);
                },
                select_lead:function (_item) {
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
                        queue_id: _item.id,
                        status:null,
                        status_sub_type: null,
                        remarks: null,
                    }
                    this.follow_up = {
                        queue_id : _item.id,
                        user_name: _item.lead.name,
                        date:null,
                        remarks:null,
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
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layouts.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>