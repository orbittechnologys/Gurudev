@extends('layout.userMain')

@section('title', ($quiz->count() > 0 ? $quiz[0]->specialCourse->course :$specialTestSubCourse[0]->course->course))
@section('content')

    <style>
        .card-test-count {
            position: absolute;
            right: 8px;
            top: 15px;
            font-size: 15px;
        }

        .mcq-details .btn-dark:hover {
            text-decoration: none;
            color: unset;
            background: unset;
        }
    </style>
    <style>
        .ribbon-box .ribbon-two {
            left: -6px;
            top: -10px;
        }

        .ribbon-box .ribbon-two span {
            width: 87px;
        }

        .badge {
            width: 47px;
        }

        .theme-primary .badge-info {
            background-color: #4259fbb3;
            color: #ffffff;
        }

        .ribbon-two-success span {
            background-color: #2dad60bd !important;
        }

        .ribbon-two-danger span {
            background-color: #cc232bd1 !important;
        }

        .ribbon-box .ribbon-two span {
            font-size: 11px;
        }

        .timer {
            position: absolute;
            top: 21px;
            font-size: 14px;
            font-weight: 600;
            right: 21px;
            color: maroon;
        }
    </style>
    <!-- Main content -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="page-title">Test Series</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/dashboard') }}">
                                    <i class="mdi mdi-home-outline"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ url('/specialTest/course') }}">Test Series Course</a>
                            </li>
                            @if ($quiz->count() > 0)
                                <li class="breadcrumb-item" aria-current="page">
                                    {{ $quiz[0]->specialCourse->course }}
                                </li>
                                @if (isset($quiz[0]->stSubCourse))
                                    <li class="breadcrumb-item" aria-current="page">
                                        {{ $quiz[0]->stSubCourse->title }}
                                    </li>
                                @endif
                            @else
                                <li class="breadcrumb-item" aria-current="page">
                                    {{ $specialTestSubCourse[0]->course->course }}
                                </li>
                            @endif
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="row mcq-details">

            @php($k = 1)
            @foreach ($specialTestSubCourse as $list)
                <?php if ($k == 4) {
                    $k = 1;
                } ?>
                <div class="col-lg-4 col-md-4 col-12">

                    <?php if ($list->payment->status == 'Success') {
                        $class = 'purchased';
                        $status = 'Purchased';
                        $statusClass = 'success';
                    } else {
                        $class = 'not-purchase';
                        $status = 'Paid';
                        $statusClass = 'danger';
                    }
                    if ($list->type == 'Free') {
                        $status = 'Free';
                        $statusClass = 'success';
                        $class = 'purchased';
                    }
                    ?>
                    <div class="box bg-img ribbon-box subject-side-badge pointer {{ $class }}"
                        slug="{{ $list->id }}" typeId="{{ $list->id }}" amount="{{ $list->amount }}"
                        courseName="{{ $list->title }}" slug="{{ $list->id }}"
                        style="background-image: url('{{ asset('user/images/abstract-' . $k++ . '.svg') }}');background-position: right top; background-size: 30% auto;">
                        <div class="ribbon-two ribbon-two-{{ $statusClass }}"><span>{{ $status }}</span></div>
                        <div class="card-body pb-2">
                            <div class="h-90">
                                <a href="javascript:void(0)" style="color: #172b4c;"
                                    class="h-10 box-title font-weight-600 text-muted hover-primary font-size-18">{{ $list->title }}</a>
                                <div class="font-weight-bold mt-35 mb-10"><span class="text-danger font-size-18"> <i
                                            class="fa fa-rupee"></i>{{ $list->amount }}/-</span></div>
                            </div>

                            <div style="display: grid">
                                <div>
                                    <div class="float-right">
                                        <h5 class="badge badge-pill badge-info">{{ $list->quizCount->quizCount + 0 }}</h5>
                                    </div>
                                    <div class="float-left mt-1">
                                        <h6>Total Quiz </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            @endforeach

            @php($border = ['info', 'success', 'danger', 'warning'])
            @php($borderCount = 0)
            @foreach ($quiz as $list)
                @if ($borderCount == 3)
                    @php($borderCount = 0)
                @endif

                @if ($list->userQuizDetail == null || $list->userQuizDetail['status'] == 0)
                    <div class="col-xl-4 col-12">
                        <div class="box bl-2 border-{{ $border[++$borderCount] }} rounded pull-up QuizWait quiz-box"
                            type="Special Test" url="{{ url('/specialTest/onlineTest/' . $list->id) }}"
                            title="{{ $list->quiz_name }}" totQuestion="{{ $list->total_questions }}"
                            instruction="{{ $instruction }}"
                            start_date_time="{{ date('d-m-Y h:i A', strtotime($list->start_date_time)) }}"
                            totQuizTime="{{ time_to_decimal($list->total_time) }}">
                            <div class="box-body">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center pr-2 justify-content-between">
                                        <h4 class="font-weight-500">
                                            {{ $list->quiz_name }}
                                        </h4>
                                    </div>
                                    <p class="font-size-16">
                                        <span> <i class="fa fa-question-circle-o"></i> {{ $list->total_questions }}
                                            Questions</span>
                                        <span class="float-right"> <i class="fa fa-clock-o-circle-o"></i>
                                            {{ time_to_decimal($list->total_time) }} Minutes</span>
                                    </p>
                                    <div class="timer" data-start='{{ $list->start_date_time }}'></div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-10">
                                    <div class="d-flex">
                                        <a href="javascript:void(0)"
                                            class="btn btn-sm btn-primary-light btn-mcq waves-effect">Start Test</a>
                                    </div>
                                    <button type="button"
                                        class="waves-effect waves-circle btn btn-circle btn-success-light"><i
                                            class="fa fa-hourglass-start"></i></button>
                                </div>
                            </div>
                        </div>
                        <!-- /.info-box -->
                    </div>

                @else
                <?php //dd($list->userQuizDetail) ?>
                    <div class="col-xl-4 col-12">
                        <div class="box bl-2 border-{{ $border[++$borderCount] }} rounded pull-up">
                            <div class="box-body">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center pr-2 justify-content-between">
                                        <h4 class="font-weight-500">
                                            {{ $list->quiz_name }}
                                        </h4>
                                    </div>
                                    <p class="font-size-16">
                                        <span> <i class="fa fa-question-circle-o"></i> {{ $list->total_questions }}
                                            Questions</span>
                                        <span class="float-right"><i class="fa fa-graduation-cap"></i>
                                           <?php $percentage= ($list->userQuizDetail->total_marks==0)?0.00:round(($list->userQuizDetail->obtained_marks / $list->userQuizDetail->total_marks) * 100, 2);
                                              echo  $percentage > 0 ? (int) $percentage : 0  ?>%
                                        </span>
                                    </p>

                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-10">
                                    <div class="d-flex">
                                        <a href="{{ url('specialTest/keyAnswer/' . $list->userQuizDetail->id) }}"
                                            class="btn btn-sm btn-warning-light btn-mcq waves-effect">Key Answers</a>
                                    </div>
                                    <a href="{{ url('specialTest/keyAnswer/' . $list->userQuizDetail->id) }}"
                                        type="button" class="waves-effect waves-circle btn btn-circle btn-success-light"><i
                                            class="fa fa-eye"></i></a>
                                </div>
                            </div>
                        </div>
                        <!-- /.info-box -->
                    </div>
                @endif
            @endforeach


        </div>
        <!-- /.row -->


    </section>
@endsection
@push('includeJs')
    <?php
    function time_to_decimal($time)
    {
        $timeArr = explode(':', $time);
        $decTime = $timeArr[0] * 60 + $timeArr[1] + $timeArr[2] / 60;
    
        return $decTime;
    } ?>
    <script>
        $('.purchased').on('click', function() {
            window.location = '{{ url('specialTest/quizList?id=') }}' + $(this).attr('slug') + '&courseType=4';
        })
    </script>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        $('.not-purchase').on('click', function() {

            let chapterName = $(this).attr('courseName')
            let amount = parseInt($(this).attr('amount'))
            let type_id = $(this).attr('typeId')
            let type='SpecialTestSubCourse'

            swal({
                    title: "Are you sure?",
                    text: "Pay <b class='font-weight-700'>" + amount + "/-</b> for chapter " + chapterName,
                    type: "warning",
                    html: true,
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Yes',
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: true
                },
                function(isConfirm) {

                    if (isConfirm) {
                        if (amount <= 0) {
                            alert('The amount must be greater than 0');
                        }
                        let course_id = type_id
                        $.ajax({
                            method: 'post',
                            url: "{{ url('/generatePaymentOrder') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "amount": amount
                            },
                            success: function(html) {

                                var options = {
                                    "key": "{{ env('RAZORPAY_KEY_ID') }}", // Enter the Key ID generated from the Dashboard
                                    "amount": (amount *
                                    100), // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                                    "currency": "INR",
                                    "name": chapterName,
                                    "order_id": html,
                                    "handler": function(response) {
                                        console.log("response",response)
                                        if (response.razorpay_payment_id) {
                                            generatePaymentDetails(course_id,
                                                html,
                                                response.razorpay_payment_id,
                                                response.razorpay_order_id,
                                                response.razorpay_signature
                                            );

                                            function generatePaymentDetails(course_id,
                                                order_id, razorpay_payment_id,
                                                razorpay_order_id, razorpay_signature) {
                                                $.ajax({
                                                    method: 'post',
                                                    url: "{{ url('/generatePayment') }}",
                                                    data: {
                                                        "_token": "{{ csrf_token() }}",
                                                        "razorpay_payment_id": razorpay_payment_id,
                                                        "razorpay_signature": razorpay_signature,
                                                        "razorpay_order_id": razorpay_order_id,
                                                        "course_id": course_id,
                                                        "order_id": order_id,
                                                        "type": type
                                                    },
                                                    success: function(response) {

                                                        try {
                                                            $('.modal-backdrop')
                                                                .remove()
                                                            if (response
                                                                .status ==
                                                                'Success') {
                                                                swal({
                                                                        html: true,
                                                                        title: "<h3>Course Purchased Successfully</h3>",
                                                                        text: "<table class='table table-bordered '>" +
                                                                            "<tr><td>Amount :</td><td>" +
                                                                            response[
                                                                                'amount'
                                                                            ] +
                                                                            "</td><tr>" +
                                                                            "<tr><td>Payment Id :</td><td>" +
                                                                            response[
                                                                                'payment_id'
                                                                            ] +
                                                                            "</td><tr>" +
                                                                            "<tr><td>Payment Date :</td><td>" +
                                                                            response[
                                                                                'payment_date'
                                                                            ] +
                                                                            "</td><tr>" +
                                                                            "<tr><td>Status :</td><td><b>" +
                                                                            response[
                                                                                'status'
                                                                            ] +
                                                                            "</b></td><tr>" +
                                                                            "</table>",
                                                                        type: "success"
                                                                    },
                                                                    function() {
                                                                        location
                                                                            .reload();
                                                                    });
                                                            } else {
                                                                swal({
                                                                    html: true,
                                                                    title: response,
                                                                });
                                                            }
                                                        } catch (err) {
                                                            swal({
                                                                html: true,
                                                                title: response,
                                                            });
                                                        }
                                                    },
                                                    error: function(response) {
                                                        $('.loading').css(
                                                            'display',
                                                            'none')
                                                        $('.modal-backdrop')
                                                            .remove()
                                                        swal({
                                                            html: true,
                                                            title: "<h3>Payment Failed</h3>",
                                                            text: JSON
                                                                .stringify(
                                                                    response
                                                                ),
                                                            type: "error"
                                                        })
                                                    }
                                                })
                                            }
                                        } else {
                                            swal({
                                                html: true,
                                                title: "<h3>Payment Failed</h3>",
                                                text: "please try later",
                                                type: "error"
                                            })
                                        }
                                    },
                                    "prefill": {
                                        "name": '{{ Auth::user()->name }}',
                                        "email": '{{ Auth::user()->email }}',
                                        "contact": '{{ Auth::user()->mobile }}',
                                    },
                                    "notes": {
                                        "address": "Razorpay Corporate Office"
                                    },
                                    "theme": {
                                        "color": "#7367f0b3"
                                    }
                                };
                                var r = new Razorpay(options);
                                r.open()
                            },
                            error: function(t) {
                                console.log(t);
                            }
                        });

                    } else {

                    }
                });
        })
    </script>
    <script>
        $('.timer').each(function(index) {

            var timerStart = $(this).attr('data-start')
            var quizBox = $(this).parents('.quiz-box')

            var countDownDate = new Date(timerStart).getTime();
            var self = $(this)
            // Update the count down every 1 second
            var x = setInterval(function() {

                // Get today's date and time
                var now = new Date().getTime();

                // Find the distance between now and the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Output the result in an element with id="demo"
                $(self).text(days + "d " + hours + "h " +
                    minutes + "m " + seconds + "s ");

                // If the count down is over, write some text
                if (distance < 0) {
                    clearInterval(x);
                    $(self).html("STARTED");
                    $(self).css("color", '#115f16c7');
                    $(quizBox).addClass('startQuiz')
                    $(quizBox).removeClass('QuizWait')
                }
            }, 1000);
        })
        $('.quiz-box').on('click', function() {
            start_date_time = $(this).attr('start_date_time')
            if ($(this).hasClass('QuizWait')) {
                swal({
                    title: "",
                    text: "Quiz starts at " + start_date_time,
                    type: "warning",
                    html: true,
                    showCancelButton: false,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Ok',
                    closeOnConfirm: true
                });
            }
        });
    </script>
@endpush
