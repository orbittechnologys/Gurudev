@extends('layout.userMain')
@section('title','Key Answers')
@push('page_styles')
    <style>
        .question div,
        .question h1,
        .question h2,
        .question h3,
        .question h4,
        .question h5 {
            display: inline;
        }

        .ribbon-bookmark.ribbon-right {
            right: -5px;
            left: auto;
        }

        .ribbon-bookmark {
            border-radius: 0;
            top: -5px;
            left: -5px;
        }

        .ribbon {
            padding: 0 20px;
            height: 30px;
            line-height: 30px;
            clear: left;
            position: absolute;
            top: 0px;
            left: -2px;
        }

        .ribbon-bookmark.ribbon-right.bg-danger:before {
            border-right-color: #fc4b6c;
            border-left-color: transparent;
        }

        .ribbon-bookmark.bg-danger:before {
            border-color: #fc4b6c;
            border-right-color: transparent;
        }

        .ribbon-bookmark.ribbon-right:before {
            right: 100%;
            left: auto;
            border-right: 15px solid #2b2b2b;
            border-left: 10px solid transparent;
        }

        .theme-primary .bg-danger {
            background-color: #fc4b6c !important;
            color: #ffffff;
        }

        .ribbon-bookmark:before {
            position: absolute;
            top: 0;
            left: 100%;
            display: block;
            width: 0;
            height: 0;
            content: '';
            border: 15px solid #2b2b2b;
            border-right: 10px solid transparent;
        }

        hr.question-details {
            border-top: 1px dotted red;
            width: 100%;
            margin: 10px 0;
            padding: 0;
        }

        .bg-danger {
            background-color: #fc4b6c !important;
            color: #fff;
        }

        /*----------------------------------- Quiz Test Page -------------------------------------*/
        .quiz-ans-list {
            display: grid;
        }

        .quiz-ans-list .custom-control-label:before {
            width: 20px !important;
            height: 20px !important;
        }

        .quiz-ans-list .custom-control-label:after {
            width: 20px !important;
            height: 20px !important;
        }

        .quiz-ans-list .custom-control-label {
            font-size: 16px;
        }

        .quiz-ans-list li {
            padding-bottom: 10px;
        }

        div#wf_qb div.wf_qb1_answer_row {
            border: none;
            box-shadow: 0 0 12px 1px rgba(110, 109, 109, 0.25);
        }

        .right_answer {
            background-image: linear-gradient(45deg, #0dbc35, #08d3a0);
            color: white;
            box-shadow: 0 0 12px 1px rgb(24, 209, 141) !important;
        }

        .right_answer_selected {}

        .wrong_answer_selected {
            background-image: linear-gradient(45deg, #f50c16, #ff4477);
            color: white;
            box-shadow: 0 0 12px 1px rgb(209, 102, 167) !important;
        }



        .hr-line-3 {
            width: 100%;
            height: 2px;
            background-image: linear-gradient(90deg, #11ffcc, #4695f8, #a966f8, #ff3243);
            border-radius: 15px;
        }

        .font-weight-600 {
            font-weight: 600;
        }

        .percentage {
            position: absolute;
            right: 20px;
            top: 10px;
        }

        .col {
            min-width: 120px;
        }
        .question{
            display:inline-flex;
        }

    </style>
    {{ Html::style('user/quiz/css/wf_qb.css') }}
    {{ Html::style('user/quiz/css/wf.css') }}
    {{ Html::style('user/stepzation-master/animate.css') }}
    {{ Html::style('user/stepzation-master/style.css') }}
    {{ Html::style('User/app-assets/css/plugins/extensions/swiper.min.css') }}
    {!! Html::style('User/app-assets/vendors/css/charts/apexcharts.css') !!}
    {!! Html::style('User/app-assets/css/core/colors/palette-gradient.min.css') !!}
@endpush

@section('content')
    <section class="content">
        <!-- parallax swiper start -->

        <div class="card">
            <div class="card-header">
                <div class="card-title ">
                    <h5> {{ $types[$key_answers['quiz']['type']] }} : {{ $key_answers['quiz']['quiz_name'] }}</h5>
                </div>
                <div class="card-controls pull-right">

                    <div class="col">
                        <div class="text-center">
                            <span class="font-large-1">{{ time_to_decimal($key_answers['total_time_taken']) }} </span>
                            <p class="font-weight-600">Minutes</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="text-center">
                            <span class="font-large-1">{{ time_to_decimal($key_answers['quiz']['total_time']) }} </span>
                            <p class="font-weight-600">Total Minutes</p>
                        </div>
                    </div>
                    <div class="col">
                        @php($percentage = ($key_answers['obtained_marks'] / $key_answers['total_marks']) * 100)
                        <div class="text-center">
                            <span class="font-large-1">{{ $percentage > 0 ? (int) $percentage : 0 }}%</span>
                            <p class="font-weight-600">Result</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col">
                                <div class="text-center text-primary">
                                    <span class="font-large-1">{{ $key_answers['quiz']['total_questions'] }}</span>
                                    <p class="font-weight-600">Total </p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="text-center text-warning">
                                    <span
                                        class="font-large-1">{{ sizeof($key_answers['user_quiz_question_detail']) }}</span>
                                    <p class="font-weight-600">Answered </p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="text-center text-success">
                                    <span class="font-large-1">{{ $key_answers['correct_answer'] }}</span>
                                    <p class="font-weight-600">Correct </p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="text-center text-danger">
                                    <span
                                        class="font-large-1">{{ sizeof($key_answers['user_quiz_question_detail']) - $key_answers['correct_answer'] }}</span>
                                    <p class="font-weight-600">Wrong </p>
                                </div>
                            </div>
                            <div class="col" style="border-right: 2px solid #c0c2c3;">
                                <div class="text-center text-danger">
                                    <span
                                        class="font-large-1 negativeCount"></span>
                                    <p class="font-weight-600">-ve </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col">
                                <div class="text-center text-info">
                                    <span class="font-large-1">{{ $key_answers['total_marks'] }}</span>
                                    <p class="font-weight-600">Total Marks </p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="text-center text-success">
                                    <span class="font-large-1">{{ abs(abs($key_answers['obtained_marks'])+abs($key_answers['negative_marks'])) }}</span>
                                    <p class="font-weight-600">Obtained Marks </p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="text-center text-danger">
                                    <span class="font-large-1">{{ $key_answers['negative_marks'] }}</span>
                                    <p class="font-weight-600">-Ve Marks</p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="text-center text-success">
                                    <span class="font-large-1">{{ $key_answers['obtained_marks'] }}</span>
                                    <p class="font-weight-600">Final Marks </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- </div>
                <div class="row"> --}}
                    {{-- @if ($key_answers['quiz']['type'] != 2) --}}

                    {{-- @endif --}}


                </div>
            </div>

        </div>
        <div class="row">
            <div class=" col-lg-12 col-12">
                @php($negativeCount = 0)
                @foreach ($key_answers['quiz']['quiz_detail'] as $question)
                    @php($answered = false)
                    <div class="card">
                        <div class="card-body pt-30">
                            <h4 class="question">
                                <div class="question_counter mt-3 mr-10">
                                    {{ sprintf('%02d', $loop->iteration) . '.' }}{{-- {{$question['id']}} --}}
                                </div>
                                <div>{!! $question['question']['question'] !!}</div>
                            </h4>{{-- wrong_answer_selected right_answer --}}

                            <div class="hr-line-3 my-2"></div>
                            <div class="wf">
                                <div id="wf_qb">
                                    <div class="wf_qb">
                                        <div id="wf_qb_answer" style="margin-top:20px;">
                                            <div id="wf_qb_answer_input" class="row">

                                                @php($alphabet = 'A')
                                                @php($wrong_answer = '')
                                                @for ($i = 1; $i <= 6; $i++)

                                                    @php($correct_answer = $question['question']['correct_answer'])
                                                    @foreach ($key_answers['user_quiz_question_detail'] as $given_answers)
                                                        @if ($question['question']['id'] == $given_answers['question_id'])
                                                            @php($answered = true)
                                                            @if ($question['question']['correct_answer'] == $given_answers['given_answer'])
                                                                @php($correct_answer_colour = 'right_answer')
                                                            @else
                                                                @php($correct_answer_colour = 'right_answer')
                                                                @php($wrong_answer_colour = 'wrong_answer')
                                                                @php($wrong_answer = $given_answers['given_answer'])
                                                            @endif
                                                        @endif
                                                    @endforeach

                                                    @php($answer_class = '')
                                                    @if ('answer' . $i == $question['question']['correct_answer'])
                                                        @php($answer_class = 'right_answer')
                                                    @elseif($wrong_answer != '' && $wrong_answer == 'answer' . $i)
                                                        @php($answer_class = 'wrong_answer_selected')
                                                         @if ($question['question']['negative_marking'] > 0)
                                                            @php($negativeCount++)
                                                        @endif
                                                    @endif


                                                    @if ($question['question']['answer' . $i] != '')
                                                        <div class="col-md-6 px-1">
                                                            <div class="wf_qb1_answer_row {{ $answer_class }}">
                                                                <div class="wf_qb1_answer_row_inner">
                                                                    <span
                                                                        class="wf_qb1_answer_col1">{{ $alphabet }}</span>
                                                                    <span
                                                                        class="wf_qb1_answer_col2">{!! $question['question']['answer' . $i] !!}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif



                                                    @php($alphabet++)
                                                @endfor
                                                <hr class="question-details" />
                                                <div class="col-lg-12 mt-2">
                                                    <div class="pull-right">
                                                        <span class="badge badge-success mr-3 p-1">Marks: {{ $question['question']['marks'] }}</span>
                                                        @if ($question['question']['negative_marking'] > 0)
                                                            <span class="badge badge-danger p-1"> Negative Marking
                                                                {!! $question['question']['negative_marking'] !!}</span>
                                                        @endif
                                                    </div>

                                                    <b>Description :</b>{!! $question['question']['description'] !!}
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($answered == false)
                            <div class="ribbon ribbon-bookmark ribbon-right bg-danger">Not Answered</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

    </section>
    <?php

    function time_to_decimal($time)
    {
        $timeArr = explode(':', $time);
        $decTime = $timeArr[0] * 60 + $timeArr[1] + $timeArr[2] / 60;

        return $decTime;
    }
    ?>
@endsection
@push('includeJs')
    <script>
    $('.negativeCount').html('{{$negativeCount}}')
        $(window).on('popstate', function(event) {
            alert("pop");
        });
        if (window.event.clientX < 40 && window.event.clientY < 0) {
            alert("Browser back button is clicked...");
        } else {
            alert("Browser refresh button is clicked...");
        }
    </script>
@endpush
