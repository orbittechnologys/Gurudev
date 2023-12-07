@extends('layout.userMain')

@section("content")

    <style>
     .card-bookmark{
         position: absolute;
         top: 20px;
         right: 10px;
     }
        .box{
            min-height: 148px;
        }

    </style>
	<!-- Main content -->
    @php($backUrl='course/subject/chapter')
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="page-title">Chapter 1</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="{{url('/course')}}">Course Android</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="{{url('/course/subject')}}">Subject</a></li>
                            <li class="breadcrumb-item" aria-current="page">Chapter</li>

                        </ol>
                    </nav>
                </div>
            </div>

        </div>
    </div>
	<section class="content">

		<div class="row">
            <div class="col-xl-4" data-toggle="tooltip" data-placement="top" title="Click to View Video">
                <a href="javscript:void(0)"  data-toggle="modal" data-target="#video-popup" class="box bg-danger bg-hover-danger bg-temple-dark">
                    <div class="box-body">
                        <div type="button" class="card-bookmark"> <span class="text-white fa fa-bookmark font-size-20"><span class="path1"></span><span class="path2"></span></span></div>
                        <span class="text-white icon-Video-camera font-size-40"><span class="path1"></span><span class="path2"></span></span>
                        <div class="text-white font-weight-600 font-size-18 mb-2 mt-5">Video Material</div>
                        <div class="text-white font-size-16"><i class="fa fa-calendar"></i> 21-2-2021
                            <span class="float-right"> <i class="fa fa-file"></i> 20 MB </span></div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4" data-toggle="tooltip" data-placement="top" title="Click to Download Material">
                <a href="{{asset('Uploads/gurudeve.pdf')}}" download="download" class="box  bg-info bg-hover-info bg-bubbles-dark">
                    <div class="box-body">
                        <div type="button" class="card-bookmark"> <span class="text-white fa fa-bookmark-o font-size-20"><span class="path1"></span><span class="path2"></span></span></div>
                        <span class="text-white icon-File-cloud font-size-40"><span class="path1"></span><span class="path2"></span></span>
                        <div class="text-white font-weight-600 font-size-18 mb-2 mt-5">Study Material</div>
                        <div class="text-white font-size-16"><i class="fa fa-calendar"></i> 21-2-2021
                            <span class="float-right"> <i class="fa fa-file"></i> 2 MB </span></div>

                    </div>
                </a>
            </div>
            <div class="col-xl-4" data-toggle="tooltip" data-placement="top" title="Click to Start Test">
                <a href="{{url('course/onlineTest/1')}}" class="box  bg-success bg-hover-success bg-brick-dark">
                    <div class="box-body">
                        <span class="text-white fa fa-question-circle-o font-size-30"><span class="path1"></span><span class="path2"></span></span>
                        <div class="text-white font-weight-600 font-size-18 mb-2 mt-5">Mock Test</div>
                        <div type="button" class="card-bookmark"> <span class="text-white fa fa-bookmark font-size-20"><span class="path1"></span><span class="path2"></span></span></div>
                        <div class="text-white font-size-16"><i class="fa fa-question-circle-o"></i> 10 Questions
                            <span class="float-right"> <i class="fa fa-clock-o"></i> 30 Minutes </span></div>
                    </div>
                </a>
            </div>



		</div>
		<!-- /.row -->


	</section>


@endsection