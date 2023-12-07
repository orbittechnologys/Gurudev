@extends('layout.adminMain')
@section("title","Chapter")
@section('content')
    <div class="row mt-30">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <h3 class="card-title">Chapters</h3>
                    <div class="card-options">
                       <a href="{{url('/admin/chapter/list')}}" class="btn btn-primary">Chapters List</a>
                    </div>
                </div>
                <div class="card-body">
                    {{ Form::model($model,array('url'=>'/admin/chapter','method' => 'post', 'files' => true))}}
                    {{ Form::hidden('id',null) }}
                    {{ Form::hidden('subject_id',null,['class'=>'_Subject-subject']) }}
                    {{ Form::hidden('material',null) }}
                    {{ Form::hidden('video_material',null) }}
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Course</label>
                                {{ Form::select('course_id',$course,null,['class'=>'select2-show-search required get-next-child','id'=>'Subject-subject','required',"placeholder"=>"Course"])}}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Subject</label>
                                {{ Form::select('subject_id',[],null,['class'=>'required select2-show-search search_dropdown Subject-subject','required',"placeholder"=>"Course"])}}

                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Chapter Name</label>
                                {{ Form::text('chapter',null,['class'=>'form-control required','placeholder'=>'Chapter Name','required']) }}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label>Chapter Type</label>
                            <div class="custom-controls-stacked mt-10">
                                <label class="custom-control custom-radio">
                                    {{ Form::radio('type', 'Paid', true, array('class'=>'custom-control-input','onclick'=>"changeCourseType('Paid')")) }}
                                    <span class="custom-control-label">Paid</span>
                                </label>
                                <label class="custom-control custom-radio">
                                    {{ Form::radio('type', 'Free', false, array('class'=>'custom-control-input ','onclick'=>"changeCourseType('Free')")) }}
                                    <span class="custom-control-label">Free</span>
                                </label>
                            </div>
                        </div>
                       {{-- <div class="col-lg-4">
                            <div class="form-group">
                                <label>Chapter Amount</label>
                                {{ Form::text('amount',null,['class'=>'form-control isNumber required courseAmount','placeholder'=>'Course Amount','autocomplete'=>'off','required']) }}
                            </div>
                        </div>--}}
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Publish Date</label>
                                {{ Form::text('date',null,['class'=>'form-control fc-datepicker required ','placeholder'=>'Publish Date','autocomplete'=>'off','required']) }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Reference Materials</label>

                                {{ Form::file('new_material',['class'=>'form-control stud_doc ','accept'=>'image/*,application/pdf',]) }}
                                @if($model['material']!='')
                                    <a class="text-danger"  href="{{uploads($model['material'])}}" target="_blank">Uploaded</a>
                                @endif
                                <span class="text-danger">Max Size : 30 MB</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Youtube Video URL</label>
                                {{ Form::text('video_material',null,['class'=>'form-control videoLink','placeholder'=>'video url','autocomplete'=>'off',]) }}

                            </div>
                        </div>
                       {{-- <div class="col-lg-4">
                            <div class="form-group">
                                <label>Discount <span class="text-danger"> ( % )</span> </label>
                                {{ Form::text('discount',null,['class'=>'form-control isNumber courseAmount','placeholder'=>'Discount','autocomplete'=>'off','required']) }}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Final Amount</label>
                                {{ Form::text('final_amount',null,['class'=>'form-control isNumber required courseAmount','readonly','placeholder'=>'Discount','autocomplete'=>'off','required']) }}
                            </div>
                        </div>--}}

                       <div class="col-md-12">
                            <div class="form-group">
                                <label>Details</label>
                                {{ Form::textarea('description',null,['rows'=>'6','class'=>'form-control','placeholder'=>'Details']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    @include('includes.save_update_button')
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection



@push('includeJs')

    {{ Html::script("js/dependent_check_out_larvela.js") }}
    @include('includes.CssJs.advanced_form')
    <script>
    $('.videoLink').bind('keypress', function(e) {
        e.preventDefault();
    });
    $('.videoLink').bind('paste', function(e) {
        var pastedData = e.originalEvent.clipboardData.getData('text');
           try{
                var video_id = pastedData.match(/v=(.{11})/)[1]
                $('.trimmedLink').val(video_id)
           }catch(error){
                alert('invalid video link')
                e.preventDefault();
                return;
            }
    });
        let courseType='{{$model['type']}}'
        if(courseType!=='') changeCourseType(courseType);
        function changeCourseType(type) {
            if(type==='Free'){
                $('.courseAmount').attr('readonly',true)
                $('.courseAmount').val(0)
            }
            else {
                $("input[name=amount]").removeAttr('readonly',true)
            }

        }
    </script>
    @if(!$model)
        <script>
            var date = new Date();
            var month = date.getMonth()+1;
            var day = date.getDate();
            var today = (day<10 ? '0' : '') + day+'-'+(month<10 ? '0' : '') + month+'-'+date.getFullYear();
            $('.fc-datepicker').val(today)
        </script>
    @endif

@endpush
