@section('title', 'Login')
<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.meta')

    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400,700|Roboto:300,400" rel="stylesheet">
    <link href="{{ asset('/user/assets/vendor_components/bootstrap/dist/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('/login.css') }}" rel="stylesheet">
    {!! Html::style('assets/css/custom.css') !!}
    {!! Html::style('user/css/vendors_css.css') !!}
    {!! Html::style('user/css/style.css') !!}
    {!! Html::style('user/css/skin_color.css') !!}


</head>

<body class="form-bg">
    <!--Gloge animation start-->
    <style>
        .signUpTitle-2 {
            font-family: 'proxima_nova_bold';
            text-align: center;
            color: #091e44;
            font-size: 28px;
            line-height: 34px;
            margin: 0 auto;
            margin-bottom: 10px;
        }

        .signUpLeftblock {
            min-height: 495px;
            overflow: hidden;
        }

        .col-1,
        .col-2,
        .col-3,
        .col-4,
        .col-5,
        .col-6 {
            padding-right: 0px;
            padding-left: 0px;
            width: 70px;
        }


        .sweet-alert button {
            font-size: 16px !important;
        }

        .bg-white {
            height: 100%;
        }

        #registration-div,
        #forgot-password,
        .pwd-second {
            display: none;
        }

        .form-bg {
            background: url('{{ asset('user/images/3.jpg') }}');
            background-repeat: no-repeat;
            background-size: cover;
        }

        .signUp-form-block {
            background: unset;
        }

        @media screen and (max-width:991px) {
            .signUpRightBlock {
                display: none;
            }

            .signUpLeftBlock {
                width: 100%;
            }

            .signUp-block {
                width: 500px;
            }
        }

        .form-control[disabled] {
            background-color: #f1f2f3 !important;
        }

        .form-control[disabled]::placeholder {
            /* Chrome, Firefox, Opera, Safari 10.1+ */
            color: #969898;
            opacity: 1;
            /* Firefox */
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .ip-mobile,
        .ip-otp,
        .password-error {
            margin-top: -10px;
        }

        .datepicker .datepicker-switch,
        .datepicker .next,
        .datepicker .prev,
        .datepicker tfoot tr th {
            cursor: pointer;
            padding: 10px;
        }

        .signUp-form-block {
            width: unset;
        }

        #registration-div {
            max-width: 385px;
        }

        .form-control::placeholder {
            /* Chrome, Firefox, Opera, Safari 10.1+ */
            color: #86a4c3;
            opacity: 1;
            /* Firefox */
        }

        .g_id_signin {
            display: flex;
            justify-content: center;
        }
    </style>

    <div class="wraper">
        <div class="row">
            <div class="col-lg-12">

            </div>
        </div>
        <div class="signUp-block">
            <div class="row">
                <div class="col-lg-12">
                    <div class="signUp-form-block ml-50 ml-xs-0 float-right mr-lg-100" id="auth-block">
                        <div class=" p-0">

                        </div>

                        <div class="signUpLeftBlock pr-0 pl-0 ">
                            <div class="bg-white  shadow-lg " id="login-div">
                                <div class="content-top-agile p-20 pb-0">
                                    <img src="{{ asset('user/images/logo-dark-text.png') }}" alt="logo">
                                    <h3 class="text-primary">Let's Get Started</h3>
                                    <p class="mb-0">Sign in to continue to Gurudev Academy.</p>
                                </div>
                                <div class="p-40">
                                    {{ Form::open(['url' => '/login', 'method' => 'POST']) }}
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent"><i
                                                        class="ti-user"></i></span>
                                            </div>
                                            {{ Form::text('user_name', '', ['class' => 'form-control pl-15 bg-transparent', 'placeholder' => 'Mobile No/Email', 'id' => 'loginUsn', 'required']) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text  bg-transparent"><i
                                                        class="ti-lock"></i></span>
                                            </div>
                                            {{ Form::password('password', ['class' => 'form-control pl-15 bg-transparent', 'placeholder' => 'Password', 'required']) }}
                                        </div>
                                    </div>
                                    @error('user_name')
                                        <div class="col-12 text-center text-danger">These credentials do not match our
                                            records</div>
                                    @enderror
                                    <div class="row">
                                        <div class="col-6">

                                        </div>
                                        <!-- /.col -->
                                        <div class="col-6">
                                            <div class="fog-pwd text-right">
                                                <a href="javascript:void(0)" id="forgot-div" class="hover-warning"><i
                                                        class="ion ion-locked"></i> Forgot Password?</a><br>
                                            </div>
                                        </div>
                                        <div class="col-12">

                                        </div>
                                        <!-- /.col -->
                                        {{-- <div class="col-1"></div>
                                        <div class="col-3"> --}}
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-danger mt-10">SIGN IN</button>
                                        </div>
                                        <div class="col-12 text-center">
                                            <h6 class="m-1 text-center">OR</h6>
                                        </div>




                                        <!-- /.col -->
                                    </div>
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <div class="g_id_signin" id="g_id_onload" data-type="standard"
                                                data-size="medium" data-theme="filled_blue" data-text="sign_in_with"
                                                data-shape="rectangular" data-logo_alignment="left"
                                                data-auto_select="false"
                                                data-client_id="526100922535-mhsce1avcd4vi7cptoetd2gcndl317mp.apps.googleusercontent.com"
                                                data-auto_prompt="false" data-ux_mode="popup"
                                                data-login_uri="{{ url('/googleAuthenticationLogin') }}">
                                            </div>
                                        </div>
                                    </div>

                                    {{ Form::close() }}
                                    <div class="text-center">
                                        <p class="mt-15 mb-0">Don't have an account? <a id="sighup_btn"
                                                href="javascript:void(0)" class="text-warning ml-5">SIGN UP</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white  shadow-lg " id="registration-div">
                                <div class="content-top-agile p-20 pb-0">
                                    <img src="{{ asset('user/images/logo-dark-text.png') }}" alt="logo">
                                    <h3 class="text-primary">Get started with Us</h3>
                                    <p class="mb-0">Register with Gurudev Academy.</p>
                                </div>
                                <div class="p-40">
                                    {{ Form::open(['url' => '/register', 'method' => 'POST', 'id' => 'registration_form']) }}

                                    @if (Session::get('email'))
                                        @php $email_name = explode('-',Session::get('email')) @endphp
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-transparent"><i
                                                            class="ti-user"></i></span>
                                                </div>
                                                {{ Form::text('name', $email_name[1], ['class' => 'form-control pl-15 bg-transparent', 'placeholder' => 'Full Name', 'required', 'readonly']) }}

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text  bg-transparent"><i
                                                            class="ti-email"></i></span>
                                                </div>
                                                {{ Form::email('email', $email_name[0], ['class' => 'form-control pl-15 bg-transparent', 'placeholder' => 'Email', 'required', 'readonly']) }}

                                            </div>
                                        </div>
                                    @else
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-transparent"><i
                                                            class="ti-user"></i></span>
                                                </div>
                                                {{ Form::text('name', '', ['class' => 'form-control pl-15 bg-transparent', 'placeholder' => 'Full Name', 'required']) }}

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text  bg-transparent"><i
                                                            class="ti-email"></i></span>
                                                </div>
                                                {{ Form::email('email', '', ['class' => 'form-control pl-15 bg-transparent', 'placeholder' => 'Email', 'required']) }}

                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text  bg-transparent"><i
                                                        class="ti-calendar"></i></span>
                                            </div>
                                            {{ Form::text('dob', '', ['class' => 'form-control pl-15 bg-transparent ', 'id' => 'datepicker', 'placeholder' => 'Date of Birth', 'required']) }}

                                        </div>
                                    </div>
                                    <div class="mb-2 row">
                                        <div class="input-group mb-3 col-md-8 pr-0 ">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text  bg-transparent"><i
                                                        class="ti-mobile"></i></span>
                                            </div>
                                            {{ Form::text('mobile', '', ['class' => 'form-control pl-15 bg-transparent mobileNo', 'id' => 'ip-mobile', 'placeholder' => 'Mobile', 'required']) }}

                                        </div>
                                        <div class="input-group mb-3 col-md-4 pl-1">
                                            {{ Form::text('otp', '', ['class' => 'form-control pl-15 bg-transparent', 'placeholder' => 'OTP', 'required', 'disabled', 'id' => 'ip-otp']) }}

                                        </div>
                                        <div class="ip-mobile text-danger ml-20 col-md-6 pointer"> </div>
                                        <div class="ip-otp text-danger ml-40 col-md-4 pointer"> </div>
                                    </div>
                                    {{-- <div class="mb-2 row">
                                        <div class="input-group mb-3 col-md-8 pr-0 ">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text  bg-transparent"><i
                                                        class="ti-location-pin"></i></span>
                                            </div>
                                            {{ Form::text('city', '', ['class' => 'form-control pl-15 bg-transparent ', 'placeholder' => 'City', 'required']) }}

                                        </div>
                                        <div class="input-group mb-3 col-md-4 pl-1">
                                            {{ Form::text('zipcode', '', ['class' => 'form-control pl-15 bg-transparent', 'placeholder' => 'Zipcode', 'required']) }}

                                        </div>

                                    </div> --}}
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text  bg-transparent"><i
                                                        class="ti-lock"></i></span>
                                            </div>
                                            <input name="password" type="password"
                                                class="form-control pl-15 bg-transparent ip-pass password1 @error('password') is-invalid @enderror"
                                                placeholder="Set Your Password Here">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text  bg-transparent"><i
                                                        class="ti-lock"></i></span>
                                            </div>
                                            <input name="confirmpassword" type="password"
                                                class="form-control ip-pass pl-15 bg-transparent password2"
                                                placeholder="Confirm Password">
                                        </div>
                                    </div>
                                    <div class="password-error text-danger ml-20  pointer"></div>
                                    <div class="row">
                                        <!-- /.col -->
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-info mt-10" id="sighIn-btn1">SIGN
                                                UP</button>

                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    </form>
                                    <div class="text-center">
                                        <p class="mt-15 mb-0">Already have an account? <a id="sighIn-btn"
                                                href="javascript:void(0)" class="text-warning ml-5">SIGN IN</a>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white  shadow-lg " id="forgot-password">
                                <div class="content-top-agile p-20 pb-0">
                                    <img src="{{ asset('user/images/logo-dark-text.png') }}" alt="logo">
                                    <h3 class="text-primary">Change Your Password</h3>

                                </div>
                                <div class="p-40">
                                    {{ Form::open(['url' => '/forgot-password', 'method' => 'POST', 'id' => 'forget_pwd_form']) }}

                                    <div class="my-4 row pwd-fst">
                                        <div class="col-md-12">
                                            <div class="input-group ">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text  bg-transparent">
                                                        <i class="ti-mobile"></i>
                                                    </span>
                                                </div>
                                                {{ Form::text('mobile', '', ['class' => 'form-control pl-15 bg-transparent mobileNo', 'id' => 'pwd-mobile', 'placeholder' => 'Mobile', 'required']) }}
                                            </div>
                                            <div class="pwd-mobile text-danger pointer"> </div>
                                        </div>


                                    </div>
                                    <div class="my-4 row pwd-fst">

                                        <div class="input-group mb-3 col-md-12 ">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text  bg-transparent"><i
                                                        class="ti-pencil"></i></span>
                                            </div>
                                            {{ Form::text('otp', '', ['class' => 'form-control pl-15 bg-transparent', 'placeholder' => 'OTP', 'required', 'disabled', 'id' => 'pwd-otp']) }}

                                        </div>
                                        <div class="pwd-otp text-danger ml-40 col-md-4 pointer"> </div>
                                    </div>
                                    <div class="form-group pwd-second">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text  bg-transparent"><i
                                                        class="ti-lock"></i></span>
                                            </div>
                                            <input required name="password" type="password"
                                                class="form-control pl-15 bg-transparent pwd-pass pwd-password1"
                                                placeholder="New Password">
                                        </div>
                                    </div>
                                    <div class="form-group pwd-second">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text  bg-transparent"><i
                                                        class="ti-lock"></i></span>
                                            </div>
                                            <input name="confirmpassword" type="password"
                                                class="form-control  pwd-pass pl-15 bg-transparent pwd-password2"
                                                placeholder="Confirm Password">
                                        </div>
                                    </div>
                                    <div class="password-error text-danger ml-20  pointer"></div>
                                    <div class="row">
                                        <!-- /.col -->
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-info mt-10" id="sighIn-btn1">Change
                                                Password</button>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    </form>
                                    <div class="text-center">
                                        <p class="mt-15 mb-0">Have Password ? <a id="sighIn-btn"
                                                href="javascript:void(0)" class="text-warning ml-5">SIGN UP</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {!! Html::script('user/js/vendors.min.js') !!}
    {!! Html::script('user/assets/vendor_components/sweetalert/sweetalert.min.js') !!}
    {!! Html::script('user/assets/vendor_components/sweetalert/jquery.sweet-alert.custom.js') !!}
    <!-- DATEPICKER JS -->
    {!! Html::script('user/assets/vendor_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') !!}
    {!! Html::script('user/assets/vendor_components/moment/min/moment.min.js') !!}
    @if ($message = Session::get('sweet-success'))
        <script>
            $(document).ready(function() {
                swal('', '{{ $message }}', 'success');
            });
        </script>
    @endif


    @if (Session::get('error-code') == 5)
        <script>
            $('#login-div').hide();
            $('#auth-block').show();
            $('#registration-div').show('slow');
        </script>
    @endif
    <script>
        $('#datepicker').datepicker({
            onSelect: function(date) {},
        }).on("changeDate", function(e) {
            $("#datepicker").val(moment(e.date).format("DD-MM-YYYY"));
            $('body .datepicker-dropdown').css('display', 'none')
        });



        $('#sighup_btn').on('click', function() {
            //$('#login-div').hide('slow');
            //commented by svn on 01-02-2023 to show the registration model by disabling the course popup
            // $('#auth-block').hide();
            // $('#course-block').show('slow');
            // $('#course-block').hide();
            $('#login-div').hide();
            $('#auth-block').show();
            $('#registration-div').show('slow');
        });
        $('#sighIn-btn, #sighIn-btn').on('click', function() {
            $('#registration-div').hide();
            $('#forgot-password').hide();
            $('#login-div').fadeIn(100);
        });
        $('#sighIn-btn').on('click', function() {
            $('#forgot-password').hide();
            $('#login-div').fadeIn(500);
        });
        $('#forgot-div').on('click', function() {
            $('#login-div').hide();
            $('#forgot-password').fadeIn(500);
        });
        $('body').on('keypress change', '.mobileNo', function(e) {

            $(this).attr({
                'pattern': '[6-9]{1}[0-9]{9}',
                'title': "Enter 10 Digit Number.."
            });
            var mob = $(this).val();
            if (mob.length > 9) {
                return false;
            }

            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                $('<p  style="position: absolute; left: 30px; top:33px"  class="text-danger error-class">Digits Only</p>')
                    .insertAfter(this).fadeOut("slow", function() {
                        $(".error-class").remove();
                    });
                return false;
            }
        });
        $('body').on('keypress change', '#ip-otp', function(e) {
            var mob = $(this).val();
            if (mob.length > 5) {
                return false;
            }
        });
    </script>
    <script>
        var otp = '';
        var submit = 0;
        var pwdsubmit = 0;

        $('#ip-mobile').on('input', function() {
            var mobile = $(this).val();
            var mobile_length = $(this).val().length;
            $('#ip-otp').attr('disabled', 'disabled');
            $('#ip-otp').val('')
            $('.ip-otp').html('');
            $('.ip-mobile').html('')
            if (mobile_length == 10) {

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '{{ url('/ajaxOtp') }}',
                    data: {
                        mobile: mobile
                    },
                    cache: false,
                    success: function(res) {


                        if (res[0] == "fail") {
                            swal('Please try again..!', '', 'error');
                            $('.ip-mobile').html(res[1]);
                            $('#ip-mobile').val('');
                        } else {
                            $('.ip-mobile').html(
                                '<a href="javascript:void(0)" class="resendOTP text-bold text-danger">Resend OTP..?</a>'
                                );
                            $('#ip-otp').removeAttr('disabled').focus();
                            otp = res[1];
                            swal('OTP Sent Successfully..!', '', 'success');
                            //$('#ip-otp').val(otp)
                        }
                    }
                });
            }
        });
        $('body').on('click', '.resendOTP', function() {
            let mesg = $(this).html()
            if (mesg == 'Resend OTP..?') {
                $('#ip-mobile').trigger('input');
            }
        })

        $('#ip-otp').on('input', function() {
            var otp_length = $(this).val().length;
            $('.ip-otp').html('');
            $('.before-otp').attr('disabled', 'disabled');
            if (otp_length == 6) {
                if (otp == $(this).val()) {
                    $('.ip-otp').html('');
                } else {
                    $('.ip-otp').html('Invalid OTP !!!');
                }
            }
        });

        $('#registration_form').submit(function() {
            if (submit == 0) {
                event.preventDefault();

                var pass = $('.password1').val();
                var con_pass = $('.password2').val();

                $('.ip-pass').html('');
                // if(otp == $('#ip-otp').val()) {
                if (pass === con_pass && pass !== '') {
                    if (pass.length < 8) {
                        $('.password-error').html('Password must contain 8 characters !!!');
                        return;
                    }

                    if ((otp !== parseInt($('#ip-otp').val()))) {
                        $('.ip-otp').html('Invalid OTP !!!');
                        $('#ip-otp').val('').focus();
                        return;
                    }
                    var email = $('input[name=email]').val();
                    $.ajax({
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ url('checkEmailAvailable') }}',
                        data: {
                            email: email
                        },
                        cache: false,
                        success: function(res) {
                            if (res == "exist") {
                                $('.password-error').html("Email is Already Exist!!!");
                                $('input[name=email]').val('').focus();
                            } else {
                                submit = 1;
                                $('#registration_form').submit();
                            }
                        }
                    });
                } else {
                    $('.password-error').html('Confirm Password not Matched !!!');
                }

            }

        });
        $('.ip-pass').on('keypress', function(e) {
            $('.password-error').html('')
            var special_char = [32, 34, 39, 96, 126, 40, 41, 91, 93, 123, 125];
            var field = $(this);
            if ($.inArray(e.which, special_char) != -1) {
                $('<p  style="position: absolute; margin-top:-18px; font-size: 13px;z-index: 5;"  class="text-danger error-class">This Character is Not Allowed</p>')
                    .insertAfter(this).fadeOut("slow", function() {
                        $(field).removeClass("mb-20");
                        $(this).css("margin-bottom", "0px");
                        $(".error-class").remove();
                    });
                return false;
            }
        });

        $('#pwd-mobile').on('input', function() {
            var mobile = $(this).val();
            var mobile_length = $(this).val().length;
            $('#pwd-otp').attr('disabled', 'disabled');
            $('#pwd-otp').val('')
            $('.pwd-otp').html('');
            $('.pwd-mobile').html('')
            if (mobile_length == 10) {
                $("body").css("cursor", "progress");
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '{{ url('/ajaxForgotPwdOtp') }}',
                    data: {
                        mobile: mobile
                    },
                    cache: false,
                    success: function(res) {
                        $("body").css("cursor", "default");
                        if (res[0] == "fail") {
                            swal('', 'Please try again..!', 'error');
                            $('.pwd-mobile').html(res[1]);
                            $('#pwd-mobile').val('');
                        } else {
                            $('.pwd-mobile').html('Resend OTP' +
                                '..?');
                            $('#pwd-otp').removeAttr('disabled').focus();
                            otp = res[1];
                            swal('OTP Sent Successfully..!', '', 'success');
                        }
                    }
                });
            }
        });
        $('body').on('click', '.pwd-mobile', function() {
            let mesg = $(this).html()
            if (mesg == 'Resend OTP..?') {
                $('#pwd-mobile').trigger('input');
            }
        })
        $('#pwd-otp').on('input', function() {
            var otp_length = $(this).val().length;

            $('.ip-otp').html('');
            $('.before-otp').attr('disabled', 'disabled');
            if (otp_length == 6) {
                if (otp == $(this).val()) {
                    $('.pwd-otp').html('');
                    $('.pwd-fst').hide()
                    $('.pwd-second').show()
                } else {
                    $('.pwd-otp').html('Invalid OTP !!!');
                }
            }
        });
        $('#forget_pwd_form').submit(function(event) {
            if (pwdsubmit == 0) {
                event.preventDefault();

                var pass = $('.pwd-password1').val();
                var con_pass = $('.pwd-password2').val();
                if (pass === con_pass && pass !== '') {
                    if (pass.length < 8) {
                        $('.password-error').html('Password must contain 8 characters !!!');
                        return
                    }

                    pwdsubmit = 1;
                    $('#forget_pwd_form').submit();

                } else {
                    $('.password-error').html('Confirm Password not Matched !!!');
                }
            }
        });
        $('#loginUsn').on('input', function(e) {
            let mob = $(this).val();
            if (isNaN(mob) && mob !== 'admin') {
                //  $(this).attr('type', 'email')
            } else {
                $(this).attr('type', 'text')
            }
            if (!isNaN(mob) && mob.length > 9) {
                $(this).val(mob.substring(0, 10))
            }
        })
    </script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
</body>

</html>
