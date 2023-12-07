@extends('layout.adminMain')
@section('title','Course')
@section('content')
    <div class="row mt-30">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <h3 class="card-title">Course</h3>
                    <div class="card-options">
                       <a href="{{url('/admin/course/list')}}" class="btn btn-primary">Course List</a>
                    </div>
                </div>
                <div class="card-body">
                    {{ Form::model($model,array('url'=>'/admin/course', 'method' => 'post', 'files' => true))}}
                    {{ Form::hidden('id',null) }}
                    {{ Form::hidden('background_image',null) }}
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Course Name</label>
                                {{ Form::text('course',null,['class'=>'form-control required','placeholder'=>'Course Name','required']) }}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label>Course Type</label>
                            <div class="custom-controls-stacked mt-10">

                                <label class="custom-control custom-radio">
                                    {{ Form::radio('course_type', 'Paid', true, array('class'=>'custom-control-input','onclick'=>"changeCourseType('Paid')")) }}
                                    <span class="custom-control-label">Paid</span>
                                </label>
                                <label class="custom-control custom-radio">
                                    {{ Form::radio('course_type', 'Free', false, array('class'=>'custom-control-input ','onclick'=>"changeCourseType('Free')")) }}
                                    <span class="custom-control-label">Free</span>
                                </label>
                                <label class="custom-control custom-radio">
                                    {{ Form::radio('course_type', 'Upcoming', false, array('class'=>'custom-control-input ','onclick'=>"changeCourseType('Upcoming')")) }}
                                    <span class="custom-control-label">Upcoming</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Background Image</label>

                                @if($model['background_image']!='')
                                    {{ Form::file('new_image',['class'=>'form-control image_type required','accept'=>'image/*',]) }}
                                    <a class="text-danger" href="{{uploads($model['background_image'])}}" target="_blank">Uploaded <br/></a>
                                @else
                                    {{ Form::file('new_image',['class'=>'form-control image_type required','accept'=>'image/*','required']) }}
                                @endif
                                 <span class="text-danger">Upload  355*180 resolution </span> <br/>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Course Amount</label>
                                {{ Form::text('amount',null,['class'=>'form-control isNumber required courseAmount','placeholder'=>'Course Amount','autocomplete'=>'off','required']) }}
                            </div>
                        </div>
                        <div class="col-lg-4">
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
                        </div>

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
    @include('includes.CssJs.advanced_form')
    <script>
        $('.courseAmount').on('input',function(){
           let amount=parseFloat( $("input[name=amount]").val());
           let discount=parseFloat( $("input[name=discount]").val());
           let finalAmt=(amount-((amount*discount)/100));

            if(isNaN(discount) || discount==0){finalAmt=amount;$("input[name=discount]").val(0) }
           if(!isNaN(finalAmt))
            $("input[name=final_amount]").val(finalAmt)
        })
        let courseType='{{$model['course_type']}}'
        if(courseType!=='') changeCourseType(courseType);
        function changeCourseType(type) {
            if(type==='Free'){
                $('.courseAmount').attr('readonly',true)
                $('.courseAmount').val(0)
            }
            else {
                $("input[name=amount], input[name=discount]").removeAttr('readonly',true)
            }

        }
    </script>

@endpush
