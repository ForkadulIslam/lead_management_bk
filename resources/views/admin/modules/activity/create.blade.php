@extends('admin.layouts.form')
@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <a href="{!! URL::to('module/activity') !!}" class="btn btn-sm btn-primary"> <i class="material-icons">list</i> lists of activity</a>
        </div>
        <!-- Color Pickers -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Schedule an activity
                        </h2>
                    </div>
                    <div class="body" id="app">
                        <div class="row clearfix">
                            {!! Form::open(['url'=>URL::to('module/activity'),'class'=>'form']) !!}
                            <div class="col-xs-6">
                                <div class="card">
                                    <div class="header">
                                        <h4 class="card-title">Details of your activity</h4>
                                    </div>
                                    <div class="body">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <label for="">Title</label>
                                                <div class="input-group">
                                                    <span id="" class="input-group-addon">
                                                        <i class="material-icons">title</i>
                                                    </span>
                                                    <div class="form-line focused" style="margin-bottom: 0px;">
                                                        {!! Form::text('title',null,['class'=>'form-control','placeholder'=>'Name','autocomplete'=>"off",'required'=>'required']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <label for="">Start time</label>
                                                <div class="input-group">
                                                    <span id="" class="input-group-addon">
                                                        <i class="material-icons">date_range</i>
                                                    </span>
                                                    <div class="form-line" style="margin-bottom: 0px;">
                                                        {!! Form::text('start_time',null,['class'=>'form-control datetimepicker','placeholder'=>'Start time..']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <label for="">End time <small>(optional)</small></label>
                                                <div class="input-group">
                                                    <span id="" class="input-group-addon">
                                                        <i class="material-icons">date_range</i>
                                                    </span>
                                                    <div class="form-line" style="margin-bottom: 0px;">
                                                        {!! Form::text('end_time',null,['class'=>'form-control datetimepicker','placeholder'=>'End time..']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <label for="">Remarks</label>
                                                <div class="input-group">
                                                    <span id="" class="input-group-addon">
                                                        <i class="material-icons">title</i>
                                                    </span>
                                                    <div class="form-line" style="margin-bottom: 0px;">
                                                        {!! Form::textarea('remarks',null,['class'=>'form-control','placeholder'=>'Remarks','rows'=>'2','cols'=>'1']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="submit" value="SAVE" class="btn btn-success btn-lg">
                                </div>

                            </div>
                            <div class="col-xs-6">
                                <div class="card clearfix">
                                    <div class="header">
                                        <h4>Activity linked with</h4>
                                    </div>
                                    <div class="body">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <label for="">Type of activity</label>
                                                <div class="input-group">
                                                    {!! Form::select('type_of_activity',get_activity_list(),null,['class'=>'selectpicker','required'=>'required']) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <label for="">Linked with</label>
                                                <div class="input-group">
                                                    {!! Form::select('linked_with',get_linked_with_list(),null,['class'=>'selectpicker','required'=>'required','@change'=>'select_linked_with','v-model'=>'linked_with']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <label for="" v-text="title_of_linked"></label>
                                                <div class="input-group">
                                                    <span id="" class="input-group-addon">
                                                        <i class="material-icons">title</i>
                                                    </span>
                                                    <div class="form-line autoCompleter">
                                                        <input type="hidden" name="id_of_linked_with" v-model="linked_id">
                                                        {!! Form::text('name_of_activity_with',null,['class'=>'form-control autocompleter',':placeholder'=>'title_of_linked','required'=>'required','autocomplete'=>'off']) !!}
                                                    </div>
                                                </div>
                                                <div class="input-group" v-show="_.size(contact_persons) > 0">
                                                    <label>Contact persons</label>
                                                    <table class="table">
                                                        <tbody>
                                                        <tr v-for="contact_person in contact_persons">
                                                            <td>
                                                                <input name="contact_person_ids[]" checked :value="contact_person.id" type="checkbox" :id="'contact_person_id_'+contact_person.id" class="filled-in" />
                                                                <label :for="'contact_person_id_'+contact_person.id" v-html="contact_person.name + '&nbsp;&nbsp;||&nbsp;&nbsp;<small>'+ contact_person.phone+'</small>'"></label>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="header">
                                        <h4 class="card-title">Calendar</h4>
                                    </div>
                                    <div class="body">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <p>Google calendar will appear here</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>



@endsection
@section('custom_page_style')

@endsection
@section('custom_page_script')
    <script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.5/dist/latest/bootstrap-autocomplete.min.js"></script>

    <script type="text/javascript">

        let app = new Vue({
            el:'#app',
            data:{
                linked_with:1,
                title_of_linked:'Name of your client',
                contact_persons:[],
                linked_id:0

            },
            methods:{
                select_linked_with:function(){
                    $('[name="name_of_activity_with"]').val('');
                    let linked_with = Number(this.linked_with);
                    this.contact_persons = [];
                    this.linked_id=0;
                    if(linked_with === 1){
                        this.title_of_linked = 'Name of your client';
                    }
                    if(linked_with === 2){
                        this.title_of_linked = 'Title of your deal';
                    }
                    if(linked_with === 3){
                        this.title_of_linked = 'Name of your individual contact person';
                    }
                }
            }
        });

        $('.autocompleter').autoComplete({
            resolver:'custom',
            events: {
                search: function (qry, callback) {
                    let url = '{!! URL::to('module/get_link_with_suggestion') !!}/'+app.linked_with+'?q='+$('.autocompleter').val();
                    axios.get(url).then(function (res) {
                        callback(res.data)
                    });
                }
            },
            minLength:2,
            preventEnter:true
        }).on('autocomplete.select', function (evt, item) {
            let req = axios.get('{!! URL::to('module/get_details_of_linked_with/') !!}/'+app.linked_with+'/'+item.value);
            req.then(function(res){
                //console.log(res.data);
                let linked_with = Number(app.linked_with);
                if(linked_with === 1){
                    app.contact_persons = res.data.contact_persons
                }
                if(linked_with === 2){
                    console.log(res.data.contact_persons);
                    app.contact_persons  = res.data.contact_persons
                }
                app.linked_id = res.data.id;
            });
            return false;
        });

        $('.datetimepicker').bootstrapMaterialDatePicker({
            format: 'Y-MM-DD HH:mm:ss',
            clearButton: true,
            weekStart: 1
        });

    </script>
@endsection