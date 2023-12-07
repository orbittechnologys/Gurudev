@extends('layout.adminMain')
@section('title','Quiz')

@section('content')

    <style>

        .back-btn{
            background-color: #e97979;
            border: 1px solid #c86565;
        }
        .back-btn:hover{
            color: #e97979 !important;
        }
        .sweet-alert h2{
            font-size: 20px !important;
            margin-top: 15px !important;
        }
        .connected-sortable {
            margin: 0 auto;
            list-style: none;
            width: 90%;
        }

        li.draggable-item {
            width: 100%;
            padding: 10px 10px;
            margin: 0;
            background-color: #f5f5f5;
            -webkit-transition: transform .25s ease-in-out;
            -moz-transition: transform .25s ease-in-out;
            -o-transition: transform .25s ease-in-out;
            transition: transform .25s ease-in-out;

            -webkit-transition: box-shadow .25s ease-in-out;
            -moz-transition: box-shadow .25s ease-in-out;
            -o-transition: box-shadow .25s ease-in-out;
            transition: box-shadow .25s ease-in-out;
            background-color: #fcfcfc;
            border-bottom: 1px solid #b8c0e5;
            z-index: 9999;
        }

        li.draggable-item:hover {
             cursor: pointer;
             background-color: #7179ea;
            color: #fff;
         }

        /* styles during drag */
        li.draggable-item .ui-sortable-helper {
           ;
            -webkit-box-shadow: 0 0 8px rgba(53,41,41, .8);
            -moz-box-shadow: 0 0 8px rgba(53,41,41, .8);
            box-shadow: 0 0 8px rgba(53,41,41, .8);
            transform: scale(1.015);
            z-index: 9999;
        }
        li.draggable-item.ui-sortable-placeholder {
            background-color: #ddd;
            -moz-box-shadow:    inset 0 0 10px #000000;
            -webkit-box-shadow: inset 0 0 10px #000000;
            box-shadow:         inset 0 0 10px #000000;
        }

        .selected_questions, .listed_questions{
            border: solid 1px #623dad;
            height: 320px;
            overflow-y: scroll;
        }

        .draggable-item h1,
        .draggable-item h2,
        .draggable-item h3,
        .draggable-item h4,
        .draggable-item h5,
        .draggable-item h6,
        .draggable-item span,
        .draggable-item i,
        .draggable-item b,
        .draggable-item div
        {
            font-size: 13px !important;
            display: inline;
        }

        .arrow_symbol{
            position: absolute;
            margin-left: -20px;
            margin-top: 25%;
        }
        .q_selected_counter{
            background-image: linear-gradient(225deg, #52f586, #29c6b1) !important;
            border: 2px solid #44aa6a !important;
        }
        .selectCourse{
            background-image: url({{ URL::asset('User/app-assets/images/pages/404.png')}});
            background-repeat: no-repeat;
            background-position: center;
            background-size: auto;
        }
        .noRecord{
            text-align: center;
            position: absolute;
            bottom: 0;
            margin: auto;
            width: 90%;
        }
        #number-tabs {
            display: flex;
            flex-direction: column;
        }

    </style>
    <div class="row mt-15">
        <div class="col-md-12">
                {{ Form::open(array('url' => 'admin/quiz/save' ,'method'=>'POST','class'=>'validate-form','id'=>'questionAddForm')) }}
            {{ Form::hidden('total_questions',null,['id'=>'total_questions']) }}
            {{ Form::hidden('quiz_type',null) }}
            {{ Form::hidden('subject_id',$chapterDetails->subject_id) }}
            {{ Form::hidden('chapter_id',$chapterDetails->id) }}
            {{ Form::hidden('type',$quiz_type) }}
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{$cardTitle}}</div>
                    <div class="card-options">
                        <div class="clearfix pull-right d-flex">
                            <div class="float-right"> {{ Form::submit('Save',['class'=>'btn btn-info wrap ml-10 questions_submit']) }}</div>
                        </div>
                    </div>
                </div>
                <div class="card-body" id="number-tabs">

                    <div class="row mt-10 mb-2">
                        <div class="col-md-12">
                            <div class="row ">
                                <div class="col-lg-6 col-md-12">
                                    <div class="row ">
                                        @if($quiz_type!=2)
                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                @if($quiz_type==0)
                                                <label class="fs-17">Title :  {{ $chapterDetails->chapter }} </label>
                                                    {{ Form::hidden('quiz_name',$chapterDetails->chapter) }}
                                                    @else
                                                    {{ Form::text('quiz_name',null,['class'=>'form-control ','placeholder'=>'Title','autocomplete'=>'off','required']) }}
                                                @endif
                                            </div>
                                        </div>
                                            {{ Form::hidden('course_id',$chapterDetails->course_id) }}
                                        @else
                                            <div class="col-lg-8">
                                                <div class="form-group mb-3">
                                                        {{ Form::text('quiz_name',null,['class'=>'form-control ','placeholder'=>'Title','autocomplete'=>'off','required']) }}
                                               </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group mb-3">
                                                    {{ Form::select('special_test_course_id',$specialTestCourses,null,['class'=>'select2-show-search required get-next-child','id'=>'SpecialTestSubCourse-title','required',"placeholder"=>"Course"])}}
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group mb-3">
                                                    <label>Sub Course</label>
                                                    {{ Form::select('subject_id',$specialTestCourses,null,['class'=>'select2-show-search  SpecialTestSubCourse-title',"placeholder"=>"Course"])}}
                                                </div>
                                            </div>
                                        @endif



                                        @if($quiz_type==2)
                                        <div class="col-lg-4">
                                            <div class="form-group mb-3">
                                                <label>Start Date</label>
                                                {{ Form::text('publish_date',null,['class'=>'form-control fc-datepicker','placeholder'=>'Start Date','autocomplete'=>'off','required']) }}
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group mb-3">
                                                <label>Start Time</label>
                                                {{ Form::time('start_time',null,['class'=>'form-control fc-timepicker','placeholder'=>'Start Time','autocomplete'=>'off','required']) }}
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group mb-3">
                                               
                                                {{ Form::select('total_time',$times,null, ['class' => 'form-control select2-show-search search_dropdown','placeholder'=>'Total Time','required']) }}
                                            </div>
                                        </div>
                                       @else
                                        <div class="col-lg-4">
                                            <div class="form-group mb-3">
                                                {{ Form::text('publish_date',null,['class'=>'form-control fc-datepicker','placeholder'=>'Publish Date','autocomplete'=>'off','required']) }}
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group mb-3">
                                                {{ Form::select('total_time',$times,null, ['class' => 'form-control select2-show-search search_dropdown','placeholder'=>'Total Time','required']) }}
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-lg-4">
                                            <div class="form-group mb-3">

                                                {{Form::select('status',array('Active' => 'Active', 'InActive' => 'In-Active'),null, ['class' => 'form-control select2']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    {{ Form::textarea('description',null,['class'=>'form-control form-input','rows'=>'5','placeholder'=>'Description']) }}
                                    {{ Form::hidden('question_id[]',null,['id'=>'questions_selected_input']) }}
                                </div>
                                <div class="col-lg-2 col-sm-6 ">
                                    <div class="counter-div mt-4">
                                        00
                                    </div>
                                    <h6 class="mt-3 text-center">Selected Questions</h6>
                                </div>
                            </div>
                            <hr class="my-0">
                        </div>
                    </div>
                    <div  class="row search-card " >
                        <div class="col-lg-3">
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">

                                {{ Form::text('tags',null,['class'=>'form-control global_search','oninput'=>'searchQuestion()',"data-toggle"=>"tooltip","data-html"=>"true","data-container"=>"body", "data-original-title"=>"<span class='text-nowrap'>Enter tags these Question's belongs to</span><br/> use (,) for Multiple Tags","required",'placeholder'=>'EX: IAS,IPS,Current Affairs']) }}
                            </div>
                        </div>

                    </div>
                    {{-- -------- Drag and Drop Start ------- --}}
                    <div class="row my-5">
                        <div class="col-md-6">
                            <h5 class="text-center">Question Poll  </h5>
                            <ul  class="connected-sortable droppable-area2 listed_questions selectCourse" id="questionPoll">
                                <li class="noRecord"><h4>Select Course !!</h4></li>
                            </ul>
                            <div id="pagination1" class="row mb-30">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="arrow_symbol"  data-toggle="tooltip" title="Drag and Drop the Questions..!">
                                <i class="fa fa-arrow-right" style="font-size:25px"></i>
                            </div>
                            <h5 class="text-center">Selected Question</h5>
                            <ul class="connected-sortable droppable-area1 selected_questions">

                            </ul>
                        </div>
                    </div>

                    {{-- -------- Drag and Drop End ------- --}}
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
    <a class="fixed-bottom-right back-btn" href="{{$backUrl}}" style="width: 50px; height: 50px">
        <i class="fa fa-arrow-left fa-2x"></i>
    </a>
@endsection
@push('includeJs')
    @include('includes.CssJs.advanced_form')
    <script>

        $('.select2-show-search').change();
        $('.global_search').on('input', function () {
            search_string =$('.global_search').val();
        });
        function searchQuestion(page='') {
           let search_string =$('.global_search').val();
            if(search_string==='')search_string='all'
            let selected_questions=[];
            for(k=0;k<$('.selected_questions li').length;k++){
                var li=$('.selected_questions').find('li')[k];
                selected_questions.push($(li).attr('data-id'));
            }
            if(selected_questions.length==0)
                selected_questions.push(0);
            selected_questions=selected_questions.join();
            $('.listed_questions').removeClass('selectCourse');
            $('#pagination1').html('')
            $('#questionPoll').load('{{ url('/admin/questions/dragDrop') }}'+'/'+ encodeURIComponent(search_string)+'/'+encodeURIComponent(selected_questions)+page, function(){

                $('#pagination1').html($('#questionPoll').find('#pagination').html())
                $('#questionPoll').find('#pagination').remove()
            });
        }
        function myPagination(page,type) {
            if (type) {
                split_str = page.split('=');
                page = split_str[1];
            }
            searchQuestion( '?page=' + page);
        }
        window.new_row = 1
        var date = new Date();
        var month = date.getMonth()+1;
        var day = date.getDate();
        var today = (day<10 ? '0' : '') + day+'-'+(month<10 ? '0' : '') + month+'-'+date.getFullYear();
        $('.fc-datepicker').val(today)
        function selectAnswer(curr, chkClass) {
            chkClass = $(curr).attr('class')
            $("." + chkClass).prop("checked", false);
            $(curr).prop("checked", true);
        }
    </script>
    <script>
        $( init );
        function init() {
            $( ".droppable-area1, .droppable-area2" ).sortable({
                connectWith: ".connected-sortable",
                stack: '.connected-sortable ul'
            }).disableSelection();
        }

        $(document).mouseup(function() {

            function indexing(){
                var count = $('.selected_questions .draggable-item').length;

                for(i=0;i<count;i++){
                    $($('.selected_questions .draggable-item')[i]).find('.index_counter').text(i+1+'. ');
                }
                $('.counter-div').text((count<10) ? '0'+count : count);
                if(count){
                    $('.counter-div').addClass('q_selected_counter')
                }else{
                    $('.counter-div').removeClass('q_selected_counter')
                }
            }
            setTimeout(indexing, 50)
        });
        $('#questionAddForm').submit(function () {

            var count = $('.selected_questions li').length;
            $('#total_questions').val(count);
            var qustion_id = [];
            for(i=0;i<count;i++){
                qustion_id[i]=$($('.selected_questions li')[i]).attr('data-id');
            }

            $('#questions_selected_input').val(qustion_id);
            if(!$('#questions_selected_input').val()){
                swal('Select At Least 1 Questions..!!','', 'error');
                event.preventDefault();
            }
        });
    </script>
@endpush

