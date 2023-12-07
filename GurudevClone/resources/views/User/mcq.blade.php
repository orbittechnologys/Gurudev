@extends('layout.userMain')
@section('title','MCQ')
@section("content")

    <style>

  .card-test-count{
      position: absolute;
      right: 8px;
      top: 15px;
      font-size: 15px;
  }
        .mcq-details .btn-dark:hover{
            text-decoration: none;
            color: unset;
            background: unset;
        }

    </style>
	<!-- Main content -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="page-title">Daily MCQ {{$quiz[0]->publish_date}}</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Current Affairs MCQs</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="float-right mr-10">
                <div class="input-group input-search">
                    <div class="input-group-append">
                        <button id="datepicker" class="btn btn-date bg-white" type="submit" id="button-addon3"><i class="ti-calendar"></i></button>

                    </div>
                    <input class="form-control" value="{{app('request')->input('searchString')}}"  id="search-input" placeholder="Search">
                    <div class="input-group-append">

                        <a href="javascript:void(0)"  class="btn btn-search bg-primary-light searchAnnouncement" type="submit" id="button-addon3"><i class="ti-search"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<section class="content">
		<div class="row mcq-details">
            @if($quiz->count()>0)
                @php($border=["info","success","danger","warning"])
                @php($borderCount=0)
                @foreach($quiz as $list)
                @if($borderCount==3) @php($borderCount=0) @endif

                @if($list->userQuizDetail!=null)
                <div class="col-xl-4 col-12">
                    <div class="box bl-2 border-{{$border[++$borderCount]}} rounded pull-up">
                        <div class="box-body">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center pr-2 justify-content-between">
                                    <h4 class="font-weight-500">
                                       {{$list->quiz_name}}
                                    </h4>
                                </div>
                                <p class="font-size-16">
                                   <span> <i class="fa fa-question-circle-o"></i> {{$list->total_questions}}</span>
                                    <span class="float-right"><i class="fa fa-graduation-cap"></i> 
                                        @php($percentage = ($list->userQuizDetail->obtained_marks /$list->userQuizDetail->total_marks) * 100)
                                        
                                        {{($percentage>0)? (int)$percentage : 0}}%  </span>
                                </p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-10">
                                <div class="d-flex">
                                   <a href="{{url('key-answers/'.$list->userQuizDetail->id)}}" class="btn btn-sm btn-primary-light btn-mcq waves-effect">Key Answers</a>
                                </div>
                                <button type="button" class="waves-effect waves-circle btn btn-circle btn-success-light"><i class="fa fa-bookmark"></i></button>
                            </div>
                        </div>
                    </div>
                    <!-- /.info-box -->
                </div>
                    @else
                <div class="col-xl-4 col-12">
                        <div class="box bl-2 border-{{$border[++$borderCount]}} rounded pull-up startQuiz"
                             type="MCQ"
                             url="{{url('/mcq/onlineTest/'.$list->id)}}"
                    title="{{$list->quiz_name}}"
                    totQuestion="{{$list->total_questions}}"
                    instruction="{{$instruction}}"
                    totQuizTime="{{time_to_decimal($list->total_time)}}">
                            <div class="box-body">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center pr-2 justify-content-between">
                                        <h4 class="font-weight-500">
                                            {{$list->quiz_name}}
                                        </h4>
                                    </div>
                                    <p class="font-size-16">
                                        <span> <i class="fa fa-question-circle-o"></i> {{$list->total_questions}} Questions</span>
                                        <span class="float-right"> <i class="fa fa-clock-o-circle-o"></i> {{time_to_decimal($list->total_time)}} Minutes</span>
                                    </p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-10">
                                    <div class="d-flex">
                                        <a href="javascript:void(0)" class="btn btn-sm btn-primary-light btn-mcq waves-effect">Start Test</a>
                                    </div>
                                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-success-light"><i class="fa fa-bookmark"></i></button>
                                </div>
                            </div>
                        </div>
                        <!-- /.info-box -->
                    </div>
                    @endif
                @endforeach
            @else

                <div class="col-md-12 col-lg-12">
                    <div class="card ">

                        <div class="card-body text-center">
                            <img src="{{ URL::asset('user/images/404.jpg')}}" class=" align-self-center not-found-img" alt="branding logo"><br/>

                            <h3 class="font-large-2 my-1"> No  MCQ Found ! </h3>


                        </div>

                    </div>
                </div>
            @endif


		</div>
		<!-- /.row -->


	</section>
@endsection
@push('includeJs')
    <?php
    function time_to_decimal($time)
    {
        $timeArr = explode(':', $time);
        $decTime = ($timeArr[0] * 60) + ($timeArr[1]) + ($timeArr[2] / 60);

        return $decTime;
    }?>
    <script>
        $('.searchAnnouncement').on('click',function () {
            let searchString=$('#search-input').val()
            window.location.href='{{url('mcq')}}?searchString='+encodeURIComponent(searchString)
        })

    </script>
@endpush
