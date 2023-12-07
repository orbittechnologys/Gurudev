<!DOCTYPE html>
<html lang="en">
<head>

    @include('includes.meta')

    {!! Html::style("user/css/vendors_css.css");!!}
    {!! Html::style("user/css/style.css");!!}
    {!! Html::style("user/css/skin_color.css");!!}
    {!! Html::style("user/css/custom.css");!!}
  
    {{--Page Specific Styles--}}
    @stack('page_styles')
    <style>
        html {
            zoom: 0.8; /* Old IE only */
            /*-moz-transform: scale(0.9);*/
            /*-webkit-transform: scale(0.8);*/
            /*transform: scale(0.8);*/
        }
    </style>
</head>
<body class="hold-transition light-skin sidebar-mini theme-primary fixed">

<div class="wrapper">
    <div id="loader"></div>

@if(!request()->is('course/onlineTest/*') && !request()->is('mcq/onlineTest/*')&& !request()->is('specialTest/onlineTest/*')))
@include('includes.user.header')
@include('includes.user.sidebar')
@else
    @include('includes.user.onlineTeastHeader')
@endif

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Main content -->
                @yield('content')
            <!-- /.content -->
           
        </div>
    </div>

    @if($backUrl)
    <a href="{{url($backUrl)}}" class=" btn  btn-primary back-btn"><i class="fa fa-arrow-circle-left"></i> </a>
@endif



    <div class="modal fade" id="video-popup">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="pittube-video">
                        <div class="video-frame" id="video-frame">
                             <!--<video id="hls-video"  class="video-js vjs-default-skin vjs-big-play-centered vjs-show-big-play-button-on-pause" preload="auto" playsinline  width="640" height="400"controls></video>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade " id="modal-announcement" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Announcements</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-center pr-2 justify-content-between">
                        <h5 class="font-weight-500 announcement-title"></h5>
                    </div>
                    <p><i class="fa fa-calendar"></i><span class="announcement-date ml-10"></span> </p>
                    <p class="font-size-14 text-justify text-fade announcement-body"></p>
                </div>
                <div class="modal-footer">
                    <a href="" target="_blank" class="btn btn-bitbucket btn-sm announcement-attachment">
                        <i class="fa fa-eye"></i> View Image
                    </a>
                    <a href="" target="_blank" class="btn btn-bitbucket btn-sm announcement-pdf">
                        <i class="fa fa-file"></i> View PDF
                    </a>
                    <a href="" target="_blank" class="btn btn-bitbucket btn-sm announcement-url">
                        <i class="fa fa-link"></i> URL
                    </a>
                    <button type="button" class="btn btn-danger btn-sm float-right" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{--------------------------- Instruction Modal ------------------------------}}

    <div class="modal fade" id="quiz_instruction_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <div class="modal-title">
                        <h3>Quiz Instructions</h3>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times</span>
                    </button>
                </div>
                <div class="modal-body">

                    <p class="text-muted text-justify" id="instruction">The quizzes consists of questions carefully designed to help you self-assess
                        your comprehension of the information presented on the topics covered in the module. No data
                        will be collected on the website regarding your responses or how many times you take the
                        quiz.</p>
                    
                    <ul class="list-group list-group-flush">

                        <li class="list-group-item">

                            <span class="font-weight-bold "> Name</span>: <span id="modal_quiz_name"> The Indian Literature</span>
                        </li>
                        <li class="list-group-item">
                            <span class="badge badge-pill bg-primary float-right" id="modal_quiz_questions">50</span>
                            <span class="font-weight-bold"> Total Questions</span>
                        </li>
                        <li class="list-group-item">
                            <span class="badge badge-pill bg-info float-right" id="modal_quiz_time">20 : 00</span>
                            <span class="font-weight-bold">Available Time </span>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                  <a href="javascript:void(0)" class="btn btn-primary float-right" id="start_quiz">Start Quiz
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="emailVarification" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <div class="modal-title">
                        <h3>Email Verification Pending</h3>
                    </div>

                </div>
                <div class="modal-body">



                            <div class="mb-4 text-sm text-gray-600 text-muted">
                                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                            </div>

                            @if (session('status') == 'verification-link-sent')
                                <div class="mb-4 font-medium text-sm text-green-600 text-muted">
                                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                                </div>
                            @endif

                            <div class="mt-4 flex items-center justify-between">
                                <form method="POST" action="{{ route('verification.send') }}">
                                    @csrf
                                    <div>
                                        <button class="btn btn-primary btn-sm float-right">
                                            {{ __('Resend Verification Email') }}
                                        </button>
                                    </div>
                                </form>
                                    <a href="{{url('/logout')}}" type="submit" class="btn btn-danger btn-sm  float-right mr-5">
                                        {{ __('Logout') }}
                                    </a>
                            </div>



                </div>
            </div>
        </div>
    </div>
</div>
    <!-- /.content-wrapper -->
    <!--<footer class="main-footer">-->

    <!--    &copy; 2021 <a href="#">Stepin Technologies</a>. All Rights Reserved.-->
    <!--</footer>-->
{!! Html::script("user/js/vendors.min.js");!!}
{!! Html::script("user/assets/icons/feather-icons/feather.min.js");!!}
{!! Html::script("user/assets/vendor_components/sweetalert/sweetalert.min.js");!!}
{!! Html::script("user/assets/vendor_components/sweetalert/jquery.sweet-alert.custom.js");!!}
  @if(!request()->is('youtubeVideos') && !request()->is('course/subject/chapter/*'))
{!! Html::script("user/assets/vendor_plugins/VideoJS/video-player.js");!!}
@endif
{!! Html::script("user/assets/vendor_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js");!!}
{!! Html::script("user/assets/vendor_components/moment/min/moment.min.js");!!}

{!! Html::script("user/js/template.js");!!}
{!! Html::script("user/js/custom.js");!!}
{!! Html::style("user/assets/vendor_plugins/VideoJS/video-js.min.css");!!}
{!! Html::script("user/assets/vendor_plugins/VideoJS/video.js");!!}
{!! Html::script("user/assets/vendor_plugins/VideoJS/youtube.js");!!}
@include('includes.CssJs.sweat-alerts')
{{--Page Specific Scripts--}}
@stack('includeJs')

    <script>

    $('#datepicker').datepicker({
        onSelect: function(date) { }, }).on("changeDate", function(e) {
        $("#search-input").val(moment(e.date).format("DD-MM-YYYY"));
    });
    $('.playVideo').on('click',function () {
        let videoUrl=$(this).attr('videoUrl')
        var video_parent = document.getElementById("video-frame");
      var video = document.createElement('video');
    	video.id = "hls-video";
    	video.className="video-js vjs-default-skin vjs-big-play-centered vjs-show-big-play-button-on-pause";
    	video.preload="auto";
    	video.controls="true";
    	video.style.width="640px";
    	video.style.height="400px";
    	video.setAttribute("playsinline","true");
    	// Append new video element to parent element
    	video_parent.appendChild(video);
            const player = videojs('hls-video', {}, () => {
            player.reset();
            player.src({ type: 'video/youtube', src: videoUrl })
            player.play()
        })
        $('#video-popup').modal('show');

    })
    $('#video-popup').on('hidden.bs.modal', function () {
       // alert('hi')
     var oldPlayer = document.getElementById('hls-video');
        videojs(oldPlayer).dispose();
        
    })
    $('.startQuiz').on('click', function() {

        $('.modal-title h3').html($(this).attr('type') + ' Instructions')
        $('#start_quiz').html('Start ' + $(this).attr('type'))
        $('#start_quiz').attr('url', $(this).attr('url'))
        $('#modal_quiz_name').html($(this).attr('title'))
        $('#modal_quiz_questions').html($(this).attr('totQuestion'))
        $('#modal_quiz_time').html($(this).attr('totQuizTime')+" Minutes")
        $('#instruction').html($(this).attr('instruction'))
        $('#quiz_instruction_modal').modal('show');
    })
        $('.quiz-box').on('click', function() {
            if($(this).hasClass('startQuiz')){

                $('.modal-title h3').html($(this).attr('type') + ' Instructions')
                $('#start_quiz').html('Start ' + $(this).attr('type'))
                $('#start_quiz').attr('url', $(this).attr('url'))
                $('#modal_quiz_name').html($(this).attr('title'))
                $('#modal_quiz_questions').html($(this).attr('totQuestion'))
                $('#modal_quiz_time').html($(this).attr('totQuizTime')+" Minutes")
                $('#instruction').html($(this).attr('instruction'))
                $('#quiz_instruction_modal').modal('show');
            }
    })
     $('#start_quiz').on('click', function() {

        window.open($(this).attr('url'), 'mywindow', 'menubar=0,resizable=1,width="100%",height=1000');
        return false;
    })
    let emailVarified = '{{ Auth::user()->email_verified_at }}'
    if (emailVarified.length == 0) {
        $('#emailVarification').modal({
            backdrop: 'static',
            keyboard: false
        }, 'show');
    }


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
</script>
</body>
</html>
