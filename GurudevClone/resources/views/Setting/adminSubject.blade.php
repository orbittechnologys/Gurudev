@extends('layout.adminMain')
@section('title','Subject')
@section('content')
    <div class="row mt-30">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <h3 class="card-title">Subjects</h3>
                    <div class="card-options">
                       <a href="{{url('/admin/subject/list')}}" class="btn btn-primary">Subject List</a>
                    </div>
                </div>
                <div class="card-body">
                    {{ Form::model($model,array('url'=>'/admin/subject', 'method' => 'post', 'files' => true))}}
                    {{ Form::hidden('id',null) }}
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Course</label>
                                {{ Form::select('course_id',$course,null,['class'=>'select2-show-search required','required',"placeholder"=>"Course"])}}

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Subject Name</label>
                                {{ Form::text('subject',null,['class'=>'form-control required','placeholder'=>'Subject Name','required']) }}
                            </div>
                        </div>
                    {{--    <div class="col-lg-6">
                            <label>Subject Type</label>
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
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Subject Amount</label>
                                {{ Form::text('amount',null,['class'=>'form-control isNumber  courseAmount','placeholder'=>'Subject Amount','autocomplete'=>'off']) }}
                            </div>
                        </div>--}}

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
    @include('includes.CssJs.advanced_form')
    <script>
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

@endpush
