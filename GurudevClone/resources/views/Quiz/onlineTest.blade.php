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

                                @php($i=1)
                                @foreach($questions['question_allocation_detail'] as $question)

                                    <div class='step-by-step-step split-h mr-10 ml-10'>
                                        <div class='default-content push-down centered-content maximize-height'>
                                            <h5 class="question">
                                                <div class="question_counter">1</div>. <div>{!! $question['question']['question'] !!}</div>
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
                                                                        @if($question['question']['answer1']!='')
                                                                            <div class="col-md-12 px-1">
                                                                                <div class="wf_qb1_answer_row wf_qb1_answer_row_open"
                                                                                     onclick="answer_selected(this,'1','{{ $question['question']['answer1'] }}','{{ $question['question']['id'] }}','{{$i-1}}','answer1')">
                                                                                    <div class="wf_qb1_answer_row_inner">
                                                                                        <input type="radio"
                                                                                               name="answer_1" value="1"
                                                                                               style="display:none;"><span
                                                                                                class="wf_qb1_answer_col1">A</span><span
                                                                                                class="wf_qb1_answer_col2">{{ $question['question']['answer1'] }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                        @if($question['question']['answer2']!='')
                                                                            <div class="col-md-12 px-1">
                                                                                <div class="wf_qb1_answer_row wf_qb1_answer_row_open"
                                                                                     onclick="answer_selected(this,'1','{{ $question['question']['answer2'] }}','{{ $question['question']['id'] }}','{{$i-1}}','answer2')">
                                                                                    <div class="wf_qb1_answer_row_inner">
                                                                                        <input type="radio"
                                                                                               name="answer_1" value="2"
                                                                                               style="display:none;"><span
                                                                                                class="wf_qb1_answer_col1">B</span><span
                                                                                                class="wf_qb1_answer_col2">{{ $question['question']['answer2'] }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                        @if($question['question']['answer3']!='')
                                                                            <div class="col-md-12 px-1">
                                                                                <div class="wf_qb1_answer_row wf_qb1_answer_row_open"
                                                                                     onclick="answer_selected(this,'1','{{ $question['question']['answer3'] }}','{{ $question['question']['id'] }}','{{$i-1}}','answer3')">
                                                                                    <div class="wf_qb1_answer_row_inner">
                                                                                        <input type="radio"
                                                                                               name="answer_1" value="3"
                                                                                               style="display:none;"><span
                                                                                                class="wf_qb1_answer_col1">C</span><span
                                                                                                class="wf_qb1_answer_col2">{{ $question['question']['answer3'] }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                        @if($question['question']['answer4']!='')
                                                                            <div class="col-md-12 px-1">
                                                                                <div class="wf_qb1_answer_row wf_qb1_answer_row_open"
                                                                                     onclick="answer_selected(this,'1','{{ $question['question']['answer4'] }}','{{ $question['question']['id'] }}','{{$i-1}}','answer4')">
                                                                                    <div class="wf_qb1_answer_row_inner">
                                                                                        <input type="radio"
                                                                                               name="answer_1" value="4"
                                                                                               style="display:none;"><span
                                                                                                class="wf_qb1_answer_col1">D</span><span
                                                                                                class="wf_qb1_answer_col2">{{ $question['question']['answer4'] }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                        @if($question['question']['answer5']!='')
                                                                            <div class="col-md-12 px-1">
                                                                                <div class="wf_qb1_answer_row wf_qb1_answer_row_open"
                                                                                     onclick="answer_selected(this,'1','{{ $question['question']['answer5'] }}','{{ $question['question']['id'] }}','{{$i-1}}','answer5')">
                                                                                    <div class="wf_qb1_answer_row_inner">
                                                                                        <input type="radio"
                                                                                               name="answer_1" value="5"
                                                                                               style="display:none;"><span
                                                                                                class="wf_qb1_answer_col1">E</span><span
                                                                                                class="wf_qb1_answer_col2">{{ $question['question']['answer5'] }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                        @if($question['question']['answer6']!='')
                                                                            <div class="col-md-12 px-1">
                                                                                <div class="wf_qb1_answer_row wf_qb1_answer_row_open"
                                                                                     onclick="answer_selected(this,'1','{{ $question['question']['answer6'] }}','{{ $question['question']['id'] }}','{{$i-1}}','answer6')">
                                                                                    <div class="wf_qb1_answer_row_inner">
                                                                                        <input type="radio"
                                                                                               name="answer_1" value="6"
                                                                                               style="display:none;"><span
                                                                                                class="wf_qb1_answer_col1">F</span><span
                                                                                                class="wf_qb1_answer_col2">{{ $question['question']['answer6'] }}</span>
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
                                        <div class="my-footer">
                                            @if($i!=1)
                                                <button type="button"
                                                        class="btn btn-sm  btn btn-primary mr-1 mb-1 waves-effect waves-light"
                                                        data-type='prev1'>Previous
                                                </button>
                                            @endif
                                            @if($i==count($questions['question_allocation_detail']))
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
                    <div class="chart-info d-flex justify-content-between">
                        <div class="text-center">

                        </div>
                        <div class="text-center">
                            <h4 class="text-success my-modal-heading ">Congratulations</h4>
                        </div>
                        <div class="text-center">
                        </div>
                    </div>
                    <div class="chart-info d-flex justify-content-between font-weight-700">
                        <div class="text-center">
                            <p class="">Total Questions</p>
                            <span class="font-large-1 total_questions"></span>
                        </div>
                        <div class="text-center">
                            <p class="">Attended Questions</p>
                            <span class="font-large-1 attended_questions"></span>
                        </div>
                        <div class="text-center">
                            <p class="">Right Answered</p>
                            <span class="font-large-1 right_answers"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a  href="{{url('/course/subject/chapter')}}" class="btn btn-sm btn-primary">Go back</a>
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
                    <button type="button" id="btn_show_result" class="btn btn-primary">Show Results</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('includeJs')
    {{ Html::script("user/quiz/stepzation-master/stepzation.js") }}
    {{ Html::script("user/quiz/js/apexcharts.min.js") }}


    <script>

        function chartDisplay(parsentage) {

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
        var total_minutes = ((+split[0]) * 60) + (+split[1]);
        var spend_time = 0;
        var endTime = new Date();
        endTime.setMinutes(endTime.getMinutes() + total_minutes);
        endTime = (Date.parse(endTime) / 1000);

        function makeTimer() {

            var now = new Date();
            now = (Date.parse(now) / 1000);

            var timeLeft = endTime - now;


            var days = Math.floor(timeLeft / 86400);
            var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
            var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600)) / 60);
            var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));

            if (hours < "10") {
                hours = "0" + hours;
            }
            if (minutes < "10") {
                minutes = "0" + minutes;
            }
            if (seconds < "10") {
                seconds = "0" + seconds;
            }

            $("#hours").html(hours + "<span>:</span>");
            $("#minutes").html(minutes + "<span>:</span>");
            $("#seconds").html(seconds + "<span></span>");

            if (hours == 0 && minutes == 0 && seconds == 0) {
                submit_answers("Time_completed");
                clearInterval(timer);
            }

            var remaining_minuts = (hours * 60) + (minutes) + 1;
            var spend_minuts = total_minutes - remaining_minuts;

            var hours = (spend_minuts / 60);
            var rhours = Math.floor(hours);
            var minutes = (hours - rhours) * 60;
            var rminutes = Math.round(minutes);
            spend_time = ('00' + rhours).slice(-2) + ":" + ('00' + (rminutes + 1)).slice(-2);
        }

        var timer = setInterval(function () {
            makeTimer();
        }, 1000);

        /****************************** Timer End *********************************/


        $('.horizontal-menu-wrapper').css('display', 'none');

        first_table_data = [];
        second_table_data = [];
        right_wrong_data = [];

        /*---------------------------- on Answer Selected -----------------------------*/
        function answer_selected(evt, selected, answer, quiz_question_id, i, ans_col) {

            second_table_data[i] = [quiz_question_id, ans_col];

            var curr_ans = $($(evt).parents('.row')[0]).find('.corr_answer').val();

            if (ans_col == curr_ans) {
                right_wrong_data[quiz_question_id] = 1;
            } else {
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

            // console.log(first_table_data);
            // console.log(second_table_data);
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

        function submit_answers(submit_type) {
            if (submited_data != 1) {
                var correct_answer = 0;
                right_wrong_data.forEach(function (item) {
                    correct_answer += parseInt(item);
                });
                var attended_questions = second_table_data.filter(Boolean).length;
                var total_questions = parseInt("{{ $questions['total_questions'] }}");

                $(".total_questions").text(total_questions);
                $(".time_taken").text(spend_time);
                $(".attended_questions").text(attended_questions);
                $(".right_answers").text(correct_answer);

                var persentage = 85;// (for temp content) parseInt(correct_answer / total_questions * 100);


                if (attended_questions || submit_type == 'Time_completed') {
                    clearInterval(timer);
                    $('.cancel').click();
                    $.ajax({
                        type: "POST",
                        url: '{{url('/test-complete')}}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'question_allocation_id': '{{ $questions['id'] }}',
                            'total_time_taken': spend_time,
                            'total_question_attended': attended_questions,
                            'correct_answer': correct_answer,
                            'second_array': JSON.stringify(second_table_data)
                        },
                        cache: false,
                        success: function (data) {
                            submited_data = 1;
                            console.log(persentage)
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
            window.location.href = '{{ url('/user/key-answers')}}/' + response_id;
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


    </script>
@endpush

