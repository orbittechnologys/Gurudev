@extends('layout.userMain')
@section('title','Dashboard')
@section("content")
    <style>
        .course img, .video img {
            height: 171px !important;
        }

        .bg-orange {
            background: linear-gradient(45deg, #ff1f6b, #ffb750);
            color: #fff;

        }
        .widget-user-2 .widget-user-image>img {
             width: 65px;
             height: 65px !important;
        }

        .carousel {
            width: 100%;
        }

        .current-affair .date {
            position: absolute;
            right: 0;
            bottom: 5px;
            color: #374152;
            font-size: smaller;
            font-weight: 700;
        }

        .current-affair .media-body {
            position: relative;
        }

        .video-post .hover-box {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 10px;
            background: rgba(34, 34, 34, 0.8);
            transition: all 0.2s ease-in-out;
            -moz-transition: all 0.2s ease-in-out;
            -webkit-transition: all 0.2s ease-in-out;
            -o-transition: all 0.2s ease-in-out;
            color: #ffff;
        }

        .hover-box a {
            color: #ffff !important;
            font-size: 12px;
        }

        .video-post:hover .hover-box {
            background: rgba(244, 67, 54, 0.9);
        }

        .video-post a.video-link {
            display: inline-block;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
            -moz-transition: all 0.2s ease-in-out;
            -webkit-transition: all 0.2s ease-in-out;
            -o-transition: all 0.2s ease-in-out;
            position: absolute;
            top: 75px;
            left: 10px;
            color: #ffffff;
            font-size: 30px;
            padding: 1px;
            outline: none;
        }

        .btn-profile-update {
            position: absolute;
            top: 89px;
            padding: 3px 10px;
            left: 21px;
        }
        .carousel-indicators li{
            background-color: #ff5722;
        }
        .current-affair .date{
            position: unset;
        }


    </style>

    <section class="content">
        <div class="row dashboard">
            @if(!empty($bannerImages))
                <div class="col-xl-8 col-12">
                    <div class="box bg-primary-light">
                        <div class="d-flex px-0">
                            <div id="carousel-example-generic-Indicators" class="carousel slide" data-ride="carousel">
                                <!-- Indicators -->
                                <ol class="carousel-indicators">
                                    @php($i=0)
                                    @foreach($bannerImages as $key=>$item)
                                        @if($item['image']!='')
                                            <li data-target="#carousel-example-generic-Indicators" data-slide-to="{{$i}}" class="{{ $i==0 ? 'active' : ''}}"></li>
                                            @php($i++)
                                        @endif
                                    @endforeach
                                </ol>
                                <!-- Wrapper for slides -->
                                <div class="carousel-inner" role="listbox">
                                    @php($i=0)
                                    @foreach($bannerImages as $key=>$item)
                                        @if($item['image']!='' )
                                            <div class="carousel-item {{ $i==0 ? 'active' : ''}}">
                                                <a href="{{ $item['url']!='' ? $item['url'] : 'javascript:void(0)'}}" {{ $item['url']!='' ? "target=_blank" : ''}} >
                                                    <div class="flex-grow-1 flex-grow-1 bg-img dask-bg bg-none-md"
                                                         style="height:230px;">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <img src="{{uploads($item['image'])}}" style="width: 100%;object-fit: cover;height:230px;"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            @php($i++)
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endif
            <div class="col-lg-4 col-12">
                <div class="box box-widget widget-user-2">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-orange">
                        <a href="updateProfile" class="btn  btn-sm btn-info-light btn-profile-update"> <i
                                    class="ti ti-pencil"></i> Edit</a>
                        <div class="widget-user-image">
                            <img class="rounded-circle bg-success-light" src="{{uploads(Auth::user()->profile)}}"
                                 onerror="this.src='{{uploads('Uploads/default.png')}}'"
                                 alt="User Avatar">
                        </div>
                        <!-- /.widget-user-image -->
                        <h3 class="widget-user-username">{{Auth::user()->name}}  </h3>
                        <h6 class="widget-user-desc mb-1">{{Auth::user()->mobile}}</h6>
                        <h6 class="widget-user-desc">{{Auth::user()->email}}</h6>

                    </div>
                    <div class="box-footer no-padding">
                        <ul class="nav d-block nav-stacked">
                            <li class="nav-item"><a href="#" class="nav-link">Course Purchased <span
                                            class="pull-right badge bg-info-light">{{$profileCount['course']}}</span></a>
                            </li>
                            <li class="nav-item"><a href="#" class="nav-link">Mock test Attended <span
                                            class="pull-right badge bg-success-light">{{$profileCount['mockTest']}}</span></a>
                            </li>
                            <li class="nav-item"><a href="#" class="nav-link">Mcq Attended <span
                                            class="pull-right badge bg-warning-light">{{$profileCount['mcq']}}</span></a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @if($course->count()>0)
            <div class="row">
                <div class="row fx-element-overlay course" style="width: 100%;">
                    <div class="col-12">
                        <div class="box no-shadow mb-0 bg-transparent">
                            <div class="box-header no-border px-0">
                                <h4 class="box-title">Courses </h4>
                                <ul class="box-controls pull-right d-md-flex d-none">
                                    <li>
                                        <a href="{{url('/course')}}" class="btn btn-primary-light px-10">View All</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    @foreach($course as $key=>$list)
                        <div class="col-lg-3 col-md-6 col-12 ">
                            <div class="box">
                                <div class="fx-card-item">
                                    <div class="fx-card-avatar fx-overlay-1"><img
                                                src="{{uploads($list->background_image)}}"
                                                alt="user"
                                                onerror="this.src='{{uploads('Uploads/Course/default/'.($key+1).'.jpeg')}}'"
                                                class="bbrr-0 bblr-0 img-cover">
                                        <div class="fx-overlay">
                                            <ul class="fx-info">
                                                <li><a class="btn btn-danger no-border"
                                                       href="{{url('/course/'.$list->slug)}}">View More</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="fx-card-content">
                                        <h4 class="box-title mb-0">{{$list->course}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        @endif
        <div class="row">
            
            @if($Announcement->count()>0)
                <div class="col-xl-4 col-12">
                    <div class="box no-shadow mb-0 bg-transparent">
                        <div class="box-header no-border px-0">
                            <h4 class="box-title">Announcements</h4>
                            <ul class="box-controls pull-right d-md-flex d-none">
                                <li>
                                    <a href="{{url('/announcements')}}" class="btn btn-primary-light px-10">View All</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        @php($colorKey=0)
                       
                        @foreach($Announcement as $key=>$list)
                           
                            <?php if($list->attachment!='') $list['attachment']=uploads($list->attachment); ?>
                            <?php if($list->pdf!='') $list['pdf']=uploads($list->pdf); ?>
                            <div class="box bt-5 border-{{$colors[$colorKey]}} rounded pull-up">
                                <div class="box-body">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center pr-2 justify-content-between">
                                            <h6 class="font-weight-500">
                                                {{ \Illuminate\Support\Str::limit($list->title, 30, $end='...') }}
                                            </h6>
                                        </div>
                                        <p class="font-size-14 text-justify">
                                            {{ \Illuminate\Support\Str::limit($list->description,60, $end='...') }}
                                            <a href="javascript:void(0)" data-content="{{$list}}"
                                               class="text-danger announcementReadMore">Read More</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @if($key==2)@break;@endif
                            @php($colorKey=($colorKey==5)?0: $colorKey+1)

                        @endforeach


                    </div>
                </div>
            @endif
            @if($currentAffairs->count()>0)
                <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                    <div class="box current-affair">
                        <div class="box-header with-border">
                            <h4 class="box-title">Current Affairs</h4>
                            <ul class="box-controls pull-right d-md-flex d-none">
                                <li>
                                    <a href="{{url('/currentAffairs')}}" class="btn btn-primary-light px-10">View
                                        All</a>
                                </li>
                            </ul>
                        </div>
                        <div class="box-body p-0">
                            <div class="media-list media-list-hover">
                                @php($colorKey=0)
                                @foreach($currentAffairs as $key=>$list)
                                    <div class="media bar-0">
                                <span class="avatar avatar-lg bg-primary-light rounded">
                                    <img class="img-cover" src="{{uploads($list->image)}}"
                                         onerror="this.src='{{uploads('Uploads/default.jpg')}}'"/>
                                </span>
                                        <a href="{{url('currentAffairs/'.$list->slug)}}" class="m-0">
                                            <div class="media-body font-weight-500  m-0">
                                                <p class="d-flex align-items-center justify-content-between">
                                                    <strong>
                                                        {{ \Illuminate\Support\Str::limit($list->title, 28, $end='...') }}</strong>

                                                </p>
                                                <p class="text-fade current-affair-description"> {!! \Illuminate\Support\Str::limit(strip_tags($list->description), 80, $end='...') !!} </p>
                                                <span class="date ">{{$list->date}}</span>
                                            </div>
                                        </a>
                                    </div>
                                    @php($colorKey=($colorKey==5)?0: $colorKey+1)
                                @endforeach


                            </div>
                        </div>
                        <div class="box-footer text-center p-10">
                            <a href="{{url('currentAffairs')}}" class="btn btn-block btn-primary-light p-5">View all</a>
                        </div>
                    </div>
                </div>
            @endif
            @if($mcq->count()>0)
                <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                    <div class="box bg-transparent no-shadow mb-30">
                        <div class="box-header no-border pb-0">
                            <h4 class="box-title">MCQ s</h4>
                            <ul class="box-controls pull-right d-md-flex d-none">
                                <li>
                                    <a href="{{url('/mcq')}}" class="btn btn-primary-light px-10">View All</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    @foreach($mcq as $list)
                        <div class="box mb-15 pull-up">
                            <div class="box-body startQuiz" type="MCQ"
                                 url="{{url('/mcq/onlineTest/'.$list->id)}}"
                                 title="{{$list->quiz_name}}"
                                 totQuestion="{{$list->total_questions}}"
                                 totQuizTime="{{time_to_decimal($list->total_time)}}">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-15 bg-warning h-50 w-50 l-h-60 rounded text-center">
                                    <span class="icon-Book-open font-size-24"><span class="path1"></span><span
                                                class="path2"></span></span>
                                        </div>
                                        <div class="d-flex flex-column font-weight-500">
                                            <a href="#" class="text-dark hover-primary mb-1 font-size-16">
                                                {{\Illuminate\Support\Str::limit($list->quiz_name, 30, $end='...')}}

                                            </a>
                                            <span class="text-fade">{{date('d-m-Y',strtotime($list->publish_date))}}</span>
                                        </div>
                                    </div>
                                    <a href="#">
                                <span class="icon-Arrow-right font-size-24"><span class="path1"></span><span
                                            class="path2"></span></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            @endif
        </div>
        @if($videoMaterials->count()>0)
        <div class="row fx-element-overlay ">
            <div class="col-12">
                <div class="box no-shadow mb-0 bg-transparent">
                    <div class="box-header no-border px-0">
                        <h4 class="box-title">Recent Videos</h4>
                        <ul class="box-controls pull-right d-md-flex d-none">
                            <li>
                                <a href="{{url('/videoMaterials')}}" class="btn btn-primary-light px-10">View All</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @foreach($videoMaterials as $list)
            @php( $video_id = explode("?v=",$list->youtube_url))
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="box video column video-post pointer playVideo" videoUrl='{{uploads($list->youtube_url)}}'>
                        <img class="card-img-top" src="https://img.youtube.com/vi/{{$video_id[1]}}/mqdefault.jpg"
                                 onerror="this.src='{{uploads('Uploads/default.jpg')}}'"   alt="Card image cap">
                        <a href="javascript:void(0)" class="video-link"><i class="fa fa-play-circle-o"></i></a>
                        <div class="hover-box">
                            <h6>
                                <a>{{ \Illuminate\Support\Str::limit($list->title, 30, $end='...') }}</a>
                            </h6>

                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        @endif
    </section>
@endsection

@push('page_scripts')
    <?php
    function time_to_decimal($time)
    {
        $timeArr = explode(':', $time);
        $decTime = ($timeArr[0] * 60) + ($timeArr[1]) + ($timeArr[2] / 60);

        return $decTime;
    }?>
    {!! Html::script("user/assets/vendor_plugins/bootstrap-slider/bootstrap-slider.js");!!}
    {!! Html::script("user/assets/vendor_components/OwlCarousel2/dist/owl.carousel.js");!!}
    {!! Html::script("user/assets/vendor_components/flexslider/jquery.flexslider.js");!!}

@endpush
