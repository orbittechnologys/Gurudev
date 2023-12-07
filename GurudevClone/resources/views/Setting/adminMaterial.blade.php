@extends('layout.adminMain')
@section("title","Study Material")
@section('content')
    @php($type=app('request')->input('type'))
    <?php if($type=='Video'){
        $typeClass='video_type';
        $acceptType='video/*';
    }
    else{
        $typeClass='stud_doc';
        $acceptType='image/*,application/pdf';
    }?>

    <div class="row mt-30">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <h3 class="card-title">{{$type}} Material</h3>
                    <div class="card-options">
                        <a href="{{url('/admin/material/list?type='.$type)}}" class="btn btn-primary">{{$type}} Material
                            List</a>
                    </div>
                </div>
                <div class="card-body">
                    {{ Form::model($model,array('url'=>'/admin/material?type='.$type, 'method' => 'post', 'files' => true))}}
                    {{ Form::hidden('id',null) }}
                    {{ Form::hidden('material',null) }}
                    {{ Form::hidden('thumbnail',null) }}
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Title</label>
                                {{ Form::text('title',null,['class'=>'form-control required','placeholder'=>'Title','required']) }}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Publish Date</label>
                                {{ Form::text('date',null,['class'=>'form-control fc-datepicker required','placeholder'=>'Publish Date','autocomplete'=>'off','required']) }}
                            </div>
                        </div>
                         @if($type!='Video')
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>{{$type}} Material</label>
                                @if($model['material']!='')
                                    {{ Form::file('new_material',['class'=>'form-control'.$typeClass,'accept'=>$acceptType,]) }}
                                    <a class="text-danger" href="{{uploads($model['material'])}}"
                                       target="_blank">Uploaded</a>
                                @else
                                    {{ Form::file('new_material',['class'=>'form-control required '.$typeClass,'accept'=>$acceptType,'required']) }}
                                @endif
                            </div>
                        </div>
                        @endif

                        @if($type=='Video')
                          
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Youtube Video URL <span class='text-danger'> Note : Paste Youtube URL only</span></label>
                                {{ Form::text('youtube_url',null,['class'=>'form-control videoLink required','placeholder'=>'Ex: https://www.youtube.com/watch?v=BHMCQr-Nt8o','autocomplete'=>'off','required']) }}

                            </div>
                        </div>
                        @endif
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Tags <i class="text-danger icon-question" data-toggle="tooltip"
                                               title="For multiple values use comma(,) for separate"></i></label>
                                {{ Form::text('tags',null,['class'=>'form-control ','placeholder'=>'Tags','autocomplete'=>'off']) }}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label>Is Display for Dashboard ?</label>
                            <div class="material-switch mt-10">
                                <input id="correct1" name="for_dashboard" value="1" class="1correct" type="checkbox" {{$model['for_dashboard']==1 ? 'checked' : '' }}/>
                                <label for="correct1" class="label-success"></label>
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
@push('includeCss')
    <style>
        .material-switch > label::before{
            background: #f44336;
        }
        .material-switch > label::after{
            background: #de190b;
        }

    </style>
@endpush


@push('includeJs')
    @include('includes.CssJs.advanced_form')
    @if(!$model)
        <script>
            var date = new Date();
            var month = date.getMonth() + 1;
            var day = date.getDate();
            var today = (day < 10 ? '0' : '') + day + '-' + (month < 10 ? '0' : '') + month + '-' + date.getFullYear();
            $('.fc-datepicker').val(today)
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
        </script>
    @endif
@endpush
