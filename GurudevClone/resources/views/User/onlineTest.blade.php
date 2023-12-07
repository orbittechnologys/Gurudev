@extends('layout.userMain')
@section("title","Mock test")
@section('content')

    <!-- BEGIN: Page CSS-->
    {{ Html::style("user/quiz/css/wf_qb.css") }}
    {{ Html::style("user/quiz/css/wf.css") }}
    {{ Html::style("user/quiz/css/swiper.min.css") }}
    {{ Html::style("user/quiz/stepzation-master/animate.css") }}
    {{ Html::style("user/quiz/stepzation-master/style.css") }}
    {{ Html::style('user/quiz/css/apexcharts.css')}}
    {{ Html::style('user/quiz/css/palette-gradient.min.css')}}

<?php
header("Cache-Control: no-store, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: ".date('d-M-Y H:i:s'));
?>

    <style>
        #timer {
            right: 10px;
            margin-top: -10px;
            display: inline-flex;
            position: absolute;
            margin-right: auto;
            line-height: 1;
            padding: 20px;
            font-size: 40px;
        }

        #hours {
            font-size: 30px;
            color: #fa6342;
        }

        #minutes {
            font-size: 30px;
            color: #fa6342;
        }

        #seconds {
            font-size: 30px;
            color: #fa6342;
        }

        .paste-styled .step-by-step .step-by-step-step {
            width: 96%;
        }
        .card {
            margin-bottom: 0px;
        }

        .neg-m-t-30 {
            margin-top: -60px;
        }

        .my-modal-heading {
            font-size: 35px;
            font-weight: 100;
            padding-bottom: 20px;
        }

        .content-wrapper, .main-footer {
            margin-left: 30px;
            margin-right: 30px;
        }

        .modal-dialog-scrollable .modal-body {
            overflow-y: auto;
            overflow-x: hidden;
        }
        .modal-body{
            color:#475f7b;
        }

    </style>

    <style>
        div#wf_qb div.wf_qb1_answer_row {
            border: none;
            box-shadow: 0 0 12px 1px rgba(110, 109, 109, 0.25);
            margin-bottom: 10px !important;
        }

        div#wf_qb div.wf_qb1_answer_row_open:hover {
            background-image: linear-gradient(45deg, #0dbc35, #08d3a0);
            color: #fff;
            border: none;
            margin-bottom: 10px !important;

        }

        div#wf_qb div.wf_qb1_answer_row_inner {
            padding: 0;
        }

        .paste-styled .step-by-step .step-by-step-step .default-content {
            min-height: 260px;
        }

        .wf-header-1 {
            background-color: #fafbfd  !important;
        }

        div#wf_qb div#wf_qb_infohead {
            box-shadow: none;
            margin-bottom: 0;
        }

        .paste-styled .step-by-step .step-by-step-step {
            width: 100%;
        }

        @media screen and (max-width: 1199px) {
            #number-tabs {
                margin-top: 70px;
            }
        }
        .question > *{
            font-family: inherit!important;
            font-size: 20px!important;
            color:#475f7b!important;
        }

        .card .progress {
            margin-bottom: 0;
            height: 3px;
        }

        .paste-styled {
            border-top: none;
        }

        div#wf_qb div#wf_qb_infohead {
            box-shadow: none;
            padding: 0 !important;
        }

        .question div, .question h1, .question h2, .question h3, .question h4, .question h5 {
            display: inline;
        }

        .sa-button-container .cancel {
            background-color: #ff4164 !important;
        }

        .card-body {
            padding: 0.15rem;
        }
        .navbar .wf_qb{
            width: 74%;
        }
        .question{
            display:inline-flex;
        }
    </style>

    <section class="content">
        <div class="row">
            <div class="col-12">

                <div class="card mb-2">
                    <div class="card-content">
                        <div class="progress progress-bar-primary">
                            <div id="process_quiz" class="progress-bar" role="progressbar" aria-valuenow="50"
                                 aria-valuemin="50" aria-valuemax="100"></div>
                        </div>
                        <div class="card-body paste-styled pr-20">
                            <div class='step-by-step' id='setup'>

                                @php($i=1)@php($totalMarks=0)
                                @foreach($questions['quiz_detail'] as $question)
                                @php($totalMarks+=$question['question']['marks'])
                                    <div class='step-by-step-step split-h mr-10 ml-10'>
                                        <div class='default-content push-down centered-content maximize-height'>
                                            <h5 class="question">
                                                <div
                                                        class="question_counter mt-3 mr-10">1 .</div> <div>{!! $question['question']['question'] !!}</div>
                                            </h5>


                                            <div class="wf">
                                                <div id="wf_qb">
                                                    <div class="wf_qb">
                                                        <form id="wf_qb_form" action="#" method="post"
                                                              onsubmit="">

                                                            <div id="wf_qb_answer">
                                                                <div id="wf_qb_answer_input">
                                                                    <div class="row mt-4">
                                                                        <input type="hidden" class="corr_answer"
                                                                               value="{{ $question['question']['correct_answer'] }}">
                                                                        <input type="hidden" class="neg_mark"
                                                                               value="{{ $question['question']['negative_marking'] }}">
                                                                        @if($question['question']['answer1']!='')
                                                                            <div class="col-md-12 px-1">
                                                                                <div class="wf_qb1_answer_row wf_qb1_answer_row_open"
                                                                                     onclick="answer_selected(this,{{ $question['question']['marks'] }},'{{ $question['question']['id'] }}','{{$i-1}}','answer1')">
                                                                                    <div class="wf_qb1_answer_row_inner">
                                                                                        <input type="radio"
                                                                                               name="answer_1" value="1"
                                                                                               style="display:none;"><span
                                                                                                class="wf_qb1_answer_col1">A</span><span
                                                                                                class="wf_qb1_answer_col2">{!! $question['question']['answer1'] !!}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                        @if($question['question']['answer2']!='')
                                                                            <div class="col-md-12 px-1">
                                                                                <div class="wf_qb1_answer_row wf_qb1_answer_row_open"
                                                                                     onclick="answer_selected(this,{{ $question['question']['marks'] }},'{{ $question['question']['id'] }}','{{$i-1}}','answer2')">
                                                                                    <div class="wf_qb1_answer_row_inner">
                                                                                        <input type="radio"
                                                                                               name="answer_1" value="2"
                                                                                               style="display:none;"><span
                                                                                                class="wf_qb1_answer_col1">B</span><span
                                                                                                class="wf_qb1_answer_col2">{!! $question['question']['answer2'] !!}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                        @if($question['question']['answer3']!='')
                                                                            <div class="col-md-12 px-1">
                                                                                <div class="wf_qb1_answer_row wf_qb1_answer_row_open"
                                                                                     onclick="answer_selected(this,{{ $question['question']['marks'] }},'{{ $question['question']['id'] }}','{{$i-1}}','answer3')">
                                                                                    <div class="wf_qb1_answer_row_inner">
                                                                                        <input type="radio"
                                                                                               name="answer_1" value="3"
                                                                                               style="display:none;"><span
                                                                                                class="wf_qb1_answer_col1">C</span><span
                                                                                                class="wf_qb1_answer_col2">{!! $question['question']['answer3'] !!}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                        @if($question['question']['answer4']!='')
                                                                            <div class="col-md-12 px-1">
                                                                                <div class="wf_qb1_answer_row wf_qb1_answer_row_open"
                                                                                     onclick="answer_selected(this,{{ $question['question']['marks'] }},'{{ $question['question']['id'] }}','{{$i-1}}','answer4')">
                                                                                    <div class="wf_qb1_answer_row_inner">
                                                                                        <input type="radio"
                                                                                               name="answer_1" value="4"
                                                                                               style="display:none;"><span
                                                                                                class="wf_qb1_answer_col1">D</span><span
                                                                                                class="wf_qb1_answer_col2">{!! $question['question']['answer4'] !!}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                        @if($question['question']['answer5']!='')
                                                                            <div class="col-md-12 px-1">
                                                                                <div class="wf_qb1_answer_row wf_qb1_answer_row_open"
                                                                                     onclick="answer_selected(this,{{ $question['question']['marks'] }},'{{ $question['question']['id'] }}','{{$i-1}}','answer5')">
                                                                                    <div class="wf_qb1_answer_row_inner">
                                                                                        <input type="radio"
                                                                                               name="answer_1" value="5"
                                                                                               style="display:none;"><span
                                                                                                class="wf_qb1_answer_col1">E</span><span
                                                                                                class="wf_qb1_answer_col2">{!! $question['question']['answer5'] !!}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                        @if($question['question']['answer6']!='')
                                                                            <div class="col-md-12 px-1">
                                                                                <div class="wf_qb1_answer_row wf_qb1_answer_row_open"
                                                                                     onclick="answer_selected(this,{{ $question['question']['marks'] }},'{{ $question['question']['id'] }}','{{$i-1}}','answer6')">
                                                                                    <div class="wf_qb1_answer_row_inner">
                                                                                        <input type="radio"
                                                                                               name="answer_1" value="6"
                                                                                               style="display:none;"><span
                                                                                                class="wf_qb1_answer_col1">F</span><span
                                                                                                class="wf_qb1_answer_col2">{!! $question['question']['answer6'] !!}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>

                                                                </div>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="card-footer">
                                            
                                            @if($question['question']['negative_marking']>0)
                                                <span class="badge badge-danger pull-right">Negative Marks: {{ $question['question']['negative_marking'] }}</span> 
                                            @endif
                                            <span class="badge badge-success pull-right mr-3">Marks: {{ $question['question']['marks'] }}</span> 
                                        </div>
                                        <div class="my-footer">
                                            @if($i!=1)
                                                <button type="button"
                                                        class="btn btn-sm  btn btn-primary mr-1 mb-1 waves-effect waves-light"
                                                        data-type='prev1'>Previous
                                                </button>
                                            @endif
                                            @if($i==count($questions['quiz_detail']))
                                                <button type="button"
                                                        class="btn btn-sm   btn-success mr-1 mb-1 waves-effect waves-light"
                                                        id="finish">Finish
                                                </button>
                                            @else
                                                <button type="button"
                                                        class="btn btn-sm  btn-primary mr-1 mb-1 waves-effect waves-light"
                                                        data-type='next1'>Next
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    @php($i++)
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- parallax swiper ends -->


    <div class="modal fade" id="ResultModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="chart-info d-flex justify-content-between mt-20">
                        <div class="text-center ">
                            <p class="mb-50 ">Total Time :<span
                                        class="font-weight-bold">{{ $questions['total_time'] }}</span></p>
                        </div>

                        <div class="text-center ">
                            <p class="mb-50 ">Time Taken <span class="font-weight-bold time_taken"> </span></p>
                        </div>
                    </div>
                    <div class="row neg-m-t-30">
                        <div class="col-sm-12 col-12 d-flex justify-content-center">
                            <div id="support-tracker"></div>
                        </div>
                    </div>
                    <div class="chart-info">
                        <div class="text-center">
                            <h4 class="text-success my-modal-heading ">Congratulations</h4>
                        </div>
                    </div>
                    <div class="text-center bg-black-10">
                        <b class="font-size-18 text-danger">Question Details</b>
                    </div>
                    <div class="chart-info d-flex justify-content-between font-weight-700 ">
                        <div class="text-center">
                            <p class="mb-0">Total</p>
                            <span class="font-large-1 total_questions"></span>
                        </div>
                        <div class="text-center">
                            <p class="mb-0">Attended</p>
                            <span class="font-large-1 attended_questions"></span>
                        </div>
                        <div class="text-center">
                            <p class="mb-0">Correct</p>
                            <span class="font-large-1 correct_questions"></span>
                        </div>
                        <div class="text-center">
                            <p class="mb-0">Wrong </p>
                            <span class="font-large-1 wrong_questions"></span>
                        </div>
                        <div class="text-center">
                            <p class="mb-0">Negative </p>
                            <span class="font-large-1 negative_questions"></span>
                        </div>
                    </div>
                    <div class="text-center bg-black-10 mt-30">
                        <b class="font-size-18 text-danger">Marks Details</b>
                    </div>
                    <div class="chart-info d-flex justify-content-between font-weight-700">
                        <div class="text-center">
                            <p class="mb-0">Total  Marks</p>
                            <span class="font-large-1 total_marks"></span>
                        </div>
                        <div class="text-center">
                            <p class="mb-0">Obtained  Marks</p>
                            <span class="font-large-1 obt_marks"></span>
                        </div>
                        <div class="text-center">
                            <p class="mb-0">Negative  Marks</p>
                            <span class="font-large-1 negative_marks"></span>
                        </div>
                        <div class="text-center">
                            <p class="mb-0">Final  Marks</p>
                            <span class="font-large-1 final_marks"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-success float-right close-btn" >Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="TimeCompleted" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body pt-10">
                                <div class="text-center">
                                    <div class="mt-5 mb-3">
                                        <i style="font-size: 120px"
                                           class="text-warning feather icon-alert-triangle"></i>
                                    </div>
                                    <h4 class="mb-5 text-warning my-modal-heading ">Time Completed ..!</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_show_result" class="btn btn-primary close-btn">Close</button>
                </div>
            </div>
        </div>
    </div>
    <a href="javascript:void(0)" class=" btn  btn-primary back-btn">Exit</a>
@endsection
@push('includeJs')
    {{ Html::script("user/quiz/stepzation-master/stepzation.js") }}
    {{ Html::script("user/quiz/js/apexcharts.min.js") }}


    <script>
      let spclTestMesg='{{$spclTestMesg}}';	
        if(spclTestMesg){	
            $('.wrapper').css('display','none')	
            swal({	
                    title: spclTestMesg,	
                    text: "",	
                    type: "warning",	
                    showCancelButton: false,	
                    confirmButtonClass: "btn-danger",	
                    cancelButtonColor: "#4da3d",	
                    confirmButtonText: "Close",	
                    closeOnConfirm: false	
                },	
                function () {	
                    window.close();	
                });	
        }
        function chartDisplay(parsentage) {
            if(parsentage<0)
                parsentage=0;

            var e = "#7367F0", t = "#EA5455", r = "#FF9F43", o = "#9c8cfc", a = "#FFC085", s = "#f29292", i = "#b9c3cd",
                l = "#e7eef7";

            var p = {
                chart: {
                    height: 220, type: "radialBar", sparkline: {
                        enabled: !1
                    }
                }
                , plotOptions: {
                    radialBar: {
                        size: 120, offsetY: 20, startAngle: -150, endAngle: 150, hollow: {
                            size: "60%"
                        },
                        track: {
                            background: "#fff", strokeWidth: "100%"
                        },
                        dataLabels: {
                            value: {
                                offsetY: 20, color: "#99a2ac", fontSize: "2rem"
                            }
                        }
                    }
                }
                , colors: [t], fill: {
                    type: "gradient", gradient: {
                        shade: "dark",
                        type: "horizontal",
                        shadeIntensity: .5,
                        gradientToColors: [e],
                        inverseColors: !0,
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 100]
                    }
                }
                , stroke: {
                    dashArray: 8
                }
                , series: [parsentage], labels: ["Result"]
            }
            new ApexCharts(document.querySelector("#support-tracker"), p).render();
        }


        /****************************** Timer Start *********************************/
        var hm = '{{$questions['total_time']}}';
        var split = hm.split(':');
        var total_minutes = ((+split[0]) * 60 ) + (+split[1]);
        var endTime= new Date('<?php echo $quiz_end ?>');
        endTime = (Date.parse(endTime) / 1000);
        var now = new Date('<?php echo date('Y-m-d H:i:s') ?>');
        now = (Date.parse(now) / 1000);
        function makeTimer() {
            now=now+1
            // alert(now)
            var timeLeft = endTime - now;
            var days = Math.floor(timeLeft / 86400);
            var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
            var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
            var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));
            if (hours < "10") { hours = "0" + hours; }
            if (minutes < "10") { minutes = "0" + minutes; }
            if (seconds < "10") { seconds = "0" + seconds; }
            $("#hours").html(hours + "<span>:</span>");
            $("#minutes").html(minutes + "<span>:</span>");
            $("#seconds").html(seconds + "<span></span>");
            if(hours== 0 && minutes == 0 && seconds == 0){
                submit_answers("Time_completed");
                clearInterval(timer);
            }
            var remaining_minuts = (parseInt(hours) * 60 ) + (parseInt(minutes)) + 1;
            var spend_minuts = total_minutes-remaining_minuts;
            var hours = (spend_minuts / 60);
            var rhours = Math.floor(hours);
            var minutes = (hours - rhours) * 60;
            var rminutes = Math.round(minutes);
            spend_time = ('00' + rhours).slice(-2) +":"+ ('00' + (rminutes+1)).slice(-2);
        }
        var timer = setInterval(function() { makeTimer(); }, 1000);
        /****************************** Timer End *********************************/


        $('.horizontal-menu-wrapper').css('display', 'none');

        first_table_data = [];
        second_table_data = [];
        right_wrong_data = [];
        neg_mark_data = [];

        /*---------------------------- on Answer Selected -----------------------------*/
        function answer_selected(evt, selected, quiz_question_id, i, ans_col) {
            
            second_table_data[i] = [quiz_question_id, ans_col,selected];

            var curr_ans = $($(evt).parents('.row')[0]).find('.corr_answer').val();
            var negative_mark = parseFloat($($(evt).parents('.row')[0]).find('.neg_mark').val());
            
            if (ans_col == curr_ans) {
                right_wrong_data[quiz_question_id] = selected;
                neg_mark_data[quiz_question_id] = 0;
            } else {
                if(negative_mark>0){
                    neg_mark_data[quiz_question_id] = negative_mark;
                }
                right_wrong_data[quiz_question_id] = 0;
            }

            answer_list = $($(evt).parents('.row')[0]).children();

            for (i = 0; i < answer_list.length; i++) {

                if ($($(answer_list[i]).children()).hasClass('wf_qb1_answer_row_done')) {
                    $($(answer_list[i]).children()).removeClass('wf_qb1_answer_row_done')
                    $($(answer_list[i]).children()).addClass('wf_qb1_answer_row_open')
                }
            }
            $(evt).addClass('wf_qb1_answer_row_done')
            $(evt).removeClass('wf_qb1_answer_row_open')
        }


        $("#finish").click(function () {
            swal({
                    title: "Are you sure?",
                    text: "Want to submit Answer...",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    cancelButtonColor: "#4da3d",
                    confirmButtonText: "Yes, Submit it!",
                    closeOnConfirm: false
                },
                function () {
                    submit_answers("finish");
                });
        });

        /*---------------------------- Ajax Submit -----------------------------*/
        var submited_data = 0;
        var response_id = 0;
        let totalMarks='{{$totalMarks}}';
        function submit_answers(submit_type) { 
            if (submited_data != 1) { 
                var correct_answer = 0;
                let obtainedMarks = 0;
                var negative_marks = 0;

                right_wrong_data.forEach(function (item) {
                    if(parseFloat(item)>0)
                        correct_answer ++;
                    obtainedMarks+=parseFloat(item);
                });
                var negative_questions=0;
                neg_mark_data.forEach(function (item) {
                    if(parseFloat(item)>0)
                        negative_questions++;
                    negative_marks += parseFloat(item);
                });
                $(".obt_marks").text(obtainedMarks.toFixed(2));
                $(".negative_marks").text(negative_marks.toFixed(2));
                obtainedMarks-=negative_marks;
              
                var attended_questions = second_table_data.filter(Boolean).length;
                var total_questions = parseInt("{{ $questions['total_questions'] }}");
                

                 $(".total_questions").text(total_questions);
                $(".time_taken").text(spend_time);
                $(".attended_questions").text(attended_questions);
                $(".correct_questions").text(correct_answer);
                $(".negative_questions").text(negative_questions);
                $(".wrong_questions").text(total_questions-correct_answer);
                $(".total_marks").text(totalMarks);
                $(".final_marks").text(obtainedMarks.toFixed(2));
                var persentage = parseInt(obtainedMarks / totalMarks * 100);


                if (attended_questions || submit_type == 'Time_completed') {
                    clearInterval(timer);
                    $('.cancel').click();
                    $.ajax({
                        type: "POST",
                        url: '{{url('/test-complete')}}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'quiz_id': '{{ $questions['id'] }}',
                            'total_time_taken': spend_time,
                            'total_question_attended': attended_questions,
                            'total_marks':totalMarks,
                            'correct_answer': correct_answer,
                            'obtained_marks': obtainedMarks,
                            'negative_marks': negative_marks,
                            'second_array': JSON.stringify(second_table_data)
                        },
                        cache: false,
                        success: function (data) {
                            submited_data = 1;
                            response_id = data['id'];
                            if (data['result'] == true) {
                                chartDisplay(persentage);
                                if (submit_type == "finish") {
                                    show_result();
                                } else {
                                    $('#TimeCompleted').modal({
                                        backdrop: 'static',
                                        keyboard: false
                                    });
                                    $('#TimeCompleted').modal().show();

                                    setTimeout(function () {
                                        $('#TimeCompleted').modal().hide();
                                        show_result();
                                    }, 20000);
                                }
                            } else {
                                swal('Try Again..!', 'Something went Wrong', 'error');
                            }
                        }
                    });
                } else {
                    swal('', 'Attend At Least 1 Question..!', 'warning');
                }

            } else {
                swal('', 'Your Answer has Already Submitted...', 'warning');
            }
        }

        $("#btn_show_result").click(function () {
            $('#TimeCompleted').modal().hide();
            show_result();
        });

        function show_result() {
            $('#ResultModal').modal({
                backdrop: 'static',
                keyboard: false
            });
            $('#ResultModal').modal().show();
            setTimeout(function () {
                //  key_answer();
            }, 30000);
        }

        function key_answer() {
            window.location.href = '{{ url('/key-answers')}}/' + response_id;
        }

        document.addEventListener('DOMContentLoaded', function (e) {
            window.stepzation = new Stepzation(document.getElementById('setup'));

            stepzation.next_step_action = function (step) {
                return []; // ugly hack
            };

            stepzation.handle_error = function (error) {
                backdrop_error(error);
            };

            stepzation.handle_finish = function (step) {
                // alert('all steps done');
                // window.location.href = '/login';
            };

            stepzation.start();
        });
        function disableF5(e) {
            if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 82) e.preventDefault();
        };

        $(document).ready(function() {
            $(document).on("keydown", disableF5);
        });
         $(this).bind("contextmenu", function(e) {
        	e.preventDefault();
        });
        document.onkeydown = function(e) {
        	if(e.keyCode == 123) {
        		return false;
        	}
        	if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
        		return false;
        	}
        	if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
        		return false;
        	}
        	if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
        		return false;
        	}

        	if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)){
        		return false;
        	}
        }
        if(window.locationbar.visible){
            //alert(window.locationbar.visible)
            window.location='{{url("fileNotFound")}}'
        }
        $('.back-btn, .close-btn').on('click',function(){
             window.close();
        })
         function RefreshParent() {
            if (window.opener != null && !window.opener.closed) {
                window.opener.location.reload();
            }
        }
        window.onbeforeunload = RefreshParent;

    </script>
@endpush

