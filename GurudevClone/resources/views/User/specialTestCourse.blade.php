@extends('layout.userMain')
@section('title','Test Series')
@section("content")
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

        .ribbon-two-success span  {
            background-color: #2dad60bd!important;
        }

       .ribbon-two-danger span {
            background-color: #cc232bd1!important;
        }
        .ribbon-box .ribbon-two span {
            font-size: 11px;
        }

    </style>
    @php($backUrl='course')
    <!-- Main content -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="page-title">Course</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i
                                            class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Test Series Course</li>

                        </ol>
                    </nav>
                </div>
            </div>

        </div>
    </div>
    <section class="content">
        <div class="row">

            @php($k=1)
            @foreach($data as $list)
                <?php if ($k == 4) $k = 1; ?>
                <div class="col-lg-4 col-md-4 col-12">

                        <?php if ($list->payment->status == 'Success') {
                            $class = 'purchased';
                            $status = 'Purchased';
                            $statusClass = 'success';
                            }else{
                            $class = 'not-purchase';
                            $status = 'Paid';
                            $statusClass = 'danger';
                        }
                        if($list->type=='Free'){
                        $status = 'Free';
                        $statusClass = 'success';
                        $class = 'purchased';
                        }
                        ?>
                        <div class="box bg-img ribbon-box subject-side-badge pointer {{$class}}" slug="{{$list->slug}}"
                             typeId="{{$list->id}}"amount="{{$list->amount}}"courseName="{{$list->course}}"slug="{{$list->slug}}"
                             style="background-image: url('{{asset('user/images/abstract-'.$k++.'.svg')}}');background-position: right top; background-size: 30% auto;">
                            <div class="ribbon-two ribbon-two-{{$statusClass}}"><span>{{$status}}</span></div>
                            <div class="card-body pb-2">
                                <div class="h-60">
                                    <a href="javascript:void(0)" class="h-10 box-title font-weight-600 text-muted hover-primary font-size-18">{{$list->course}}</a>
                                    <div class="font-weight-bold mt-10 mb-10"><span class="text-danger font-size-18"> <i class="fa fa-rupee"></i>{{$list->amount}}/-</span></div>
                                </div>

                                <div style="display: grid">



                                    <div>
                                        <div class="float-right">
                                            <h5 class="badge badge-pill badge-info">{{$list->quizCount->quizCount+0}}</h5>
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


        </div>
    </section>
@endsection
@push('includeJs')
    <script>

        $('.purchased').on('click', function () {
            window.location = '{{url('specialTest/quizList?slug=')}}' + $(this).attr('slug')+'&courseType=2';
        })

    </script>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        $('.not-purchase').on('click', function() {

            let chapterName = $(this).attr('courseName')
            let amount = parseInt($(this).attr('amount'))
            let type_id = $(this).attr('typeId')
            let type='SpecialTestCourse'

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
                                    "amount": (amount *100), // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                                    "currency": "INR",
                                    "name": chapterName,
                                    "order_id": html,
                                    "handler": function(response) {
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
                                                        $('.preloader')
                                                            .addClass('disable')
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
@endpush
