@extends('layout.userMain')
@section('title', 'Materials')
@section('content')

    <style>
        .card-bookmark {
            position: absolute;
            top: 20px;
            right: 10px;
        }

        .box {
            min-height: 148px;
        }

        .keyAnswer,
        .keyAnswer:hover {
            font-size: 15px;

            color: #fff !important;
        }

        .keyAnswer {
            animation: blinker 1s linear infinite;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
    </style>
    <!-- Main content -->
    <?php
    header('Cache-Control: no-store, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Expires: ' . date('d-M-Y H:i:s'));
    ?>
    @php($backUrl = 'course/subject/' . $data->subject->slug)
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="page-title">Materials </h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}"><i
                                        class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="{{ url('/course') }}">Course </a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page"><a href="{{ url($backUrl) }}">Chapter</a></li>
                            <li class="breadcrumb-item" aria-current="page">Material</li>

                        </ol>
                    </nav>
                </div>
            </div>

        </div>
    </div>
    <section class="content">

        <div class="row match-height">
            @php($playVideo = '#video-popup-1')@php($videoMaterialTitle = 'Video Material')
            @if ($data->video_material == '')
                @php($playVideo = '')
                @php($videoMaterialTitle = 'Material Not Uploaded')
            @endif

            <div class="col-xl-4" data-toggle="tooltip" data-placement="top" title="Click to View Video">
                <a href="javascript:void(0)" videoUrl='{{ $data->video_material }}' data-toggle="modal"
                    data-target="{{ $playVideo }}" class="box column bg-danger bg-hover-danger bg-temple-dark">
                    <div class="box-body ">
                        <div type="button" class="card-bookmark"><span class="text-white fa fa-bookmark font-size-20"><span
                                    class="path1"></span><span class="path2"></span></span></div>
                        <span class="text-white icon-Video-camera font-size-40"><span class="path1"></span><span
                                class="path2"></span></span>
                        <div class="text-white font-weight-600 font-size-18 mb-2 mt-5">{{ $videoMaterialTitle }}</div>
                        <div class="text-white font-size-16"><i class="fa fa-calendar"></i> {{ $data->date }}
                            <span class="float-right"> <i class="fa fa-file"></i> </span>
                        </div>
                    </div>
                </a>
            </div>
            @php($studyMaterialTitle = 'Study Material')
            @php($url = url('studyMaterialView/' . $data->slug))
            @if ($data->material == '')
                @php($url = '#')
                @php($studyMaterialTitle = 'Material Not Uploaded')
            @endif
            <div class="col-xl-4" data-toggle="tooltip" data-placement="top" title="Click to View Material">
                <a href="{{ $url }}" class="box column  bg-info bg-hover-info bg-bubbles-dark">
                    <div class="box-body">
                        <div type="button" class="card-bookmark"><span
                                class="text-white fa fa-bookmark-o font-size-20"><span class="path1"></span><span
                                    class="path2"></span></span></div>
                        <span class="text-white icon-File-cloud font-size-40"><span class="path1"></span><span
                                class="path2"></span></span>
                        <div class="text-white font-weight-600 font-size-18 mb-2 mt-5">{{ $studyMaterialTitle }}</div>
                        <div class="text-white font-size-16"><i class="fa fa-calendar"></i> {{ $data->date }}
                            <span class="float-right"> <i class="fa fa-file"></i>
                                </span>
                        </div>
                    </div>
                </a>
            </div>
            @if ($quiz == null)
                <div class="col-xl-4" data-toggle="tooltip" data-placement="top" title="Click to Start Test">
                    <a href="javascript:void(0)" class="box column  bg-success bg-hover-success bg-brick-dark">
                        <div class="box-body">
                            <span class="text-white fa fa-question-circle-o font-size-30"><span class="path1"></span><span
                                    class="path2"></span></span>
                            <div class="text-white font-weight-600 font-size-18 mb-2 mt-5">No Mock Test</div>
                            <div type="button" class="card-bookmark"><span
                                    class="text-white fa fa-bookmark font-size-20"><span class="path1"></span><span
                                        class="path2"></span></span></div>
                            <div class="text-white font-size-16"><i class="fa fa-question-circle-o"></i> - Questions
                                <span class="float-right"> <i class="fa fa-clock-o"></i> - Minutes </span>
                            </div>
                        </div>
                    </a>
                </div>
            @else
                @if ($quiz->userQuizDetail)
                    <div class="col-xl-4" data-toggle="tooltip" data-placement="top" title="Click to View Result">
                        <a href="{{ url('/key-answers/' . $quiz->userQuizDetail->id) }}"
                            class="box column bg-success bg-hover-success bg-brick-dark">
                            <div class="box-body">
                                <span class="text-white fa fa-question-circle-o font-size-30"><span
                                        class="path1"></span><span class="path2"></span></span>
                                <div class="text-white font-weight-600 font-size-18 mb-2 mt-5">{{ $quiz->quiz_name }}</div>
                                <div type="button" class="card-bookmark">

                                    <span class="text-white fa fa-bookmark font-size-20"> <span class="path1"></span><span
                                            class="path2"></span></span>
                                </div>
                                <div class="text-white font-size-16"><i class="fa fa-eye"></i> <span class="keyAnswer">Key
                                        Answers</span>
                                    <span class="float-right"> <i class="fa fa-graduation-cap"></i>
                                        @php($percentage = ($quiz->userQuizDetail->obtained_marks / $quiz->userQuizDetail->total_marks) * 100)
                                        {{ $percentage > 0 ? (int) $percentage : 0 }}% Result </span>
                                </div>
                            </div>
                        </a>
                    </div>
                @else
                    <div class="col-xl-4" data-toggle="tooltip" data-placement="top" title="Click to Start Test">
                        <a href="javascript:void(0)" type="Mock Test" url="{{ url('/course/onlineTest/' . $quiz->id) }}"
                            title="{{ $quiz->quiz_name }}" totQuestion="{{ $quiz->total_questions }}"
                            instruction="{{ $instruction }}" totQuizTime="{{ time_to_decimal($quiz->total_time) }}"
                            class="box column bg-success bg-hover-success bg-brick-dark startQuiz">
                            <div class="box-body">
                                <span class="text-white fa fa-question-circle-o font-size-30"><span
                                        class="path1"></span><span class="path2"></span></span>
                                <div class="text-white font-weight-600 font-size-18 mb-2 mt-5">{{ $quiz->quiz_name }}
                                </div>
                                <div type="button" class="card-bookmark">
                                    <span class="text-white fa fa-bookmark font-size-20"> <span
                                            class="path1"></span><span class="path2"></span></span>
                                </div>
                                <div class="text-white font-size-16"><i class="fa fa-question-circle-o"></i>
                                    {{ $quiz->total_questions }} Questions
                                    <span class="float-right"> <i class="fa fa-clock-o"></i>
                                        {{ time_to_decimal($quiz->total_time) }} Minutes </span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
            @endif


        </div>
        <!-- /.row -->
        <!-- /.row -->
        <div class="modal fade" id="video-popup-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="pittube-video">
                            <div class="video-frame">
                                {{-- <video id="youtube-video" class="video-js" controls poster="" data-setup="{}">
                                </video> --}}

                                <video id="youtube-video" class="video-js vjs-default-skin" controls width="640"
                                    height="400"
                                    data-setup='{ "techOrder": ["youtube", "html5"], "sources": [{ "type": "video/youtube", "src": "{{ $data->video_material }}"}] }'>
                                </video>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <?php
    function filesize_formatted($path)
    {
        //dd($path);
        $size = filesize($path);
    
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }
    function time_to_decimal($time)
    {
        $timeArr = explode(':', $time);
        $decTime = $timeArr[0] * 60 + $timeArr[1] + $timeArr[2] / 60;
    
        return $decTime;
    }
    ?>

@endsection
@push('includeJs')
    {!! Html::style('user/assets/vendor_plugins/VideoJS/video-js.min.css') !!}
    {!! Html::script('user/assets/vendor_plugins/VideoJS/video.js') !!}
    
@endpush
