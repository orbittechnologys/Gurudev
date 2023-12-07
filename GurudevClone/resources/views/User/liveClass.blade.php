@extends('layout.userMain')
@section('title','Live Class')
@section("content")
    <!-- Main content -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="page-title">Live Class</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Live Class</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="row">
            @foreach($tableList as $list)
                <?php
                    $minutes=explode(':',$list->Remaining_Minutes);
                $list->Remaining_Minutes=$minutes[0]*60+$minutes[1];
               ?>
                <div class="col-md-12 col-lg-4">
                    <div class="card cursor-pointer bl-3 border-primary">
                        <div class="card-footer d-flex justify-content-between bt-0 pb-0">
                            <span class="text-muted"><i class="fa fa-clock-o"></i> {{ date('d-M-y',strtotime($list->start_time))}} - {{ date('h:i A',strtotime($list->start_time))}}</span>
                            <ul class="list-inline mb-0 socialMedia">
                                <li class="list-inline-item">
                                    Duration: {{ $list->duration }}
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"> {{ \Illuminate\Support\Str::limit($list->title, 30, $end='...') }}</h5>
                            <p class="card-text" style="height: 43px;"> {{ \Illuminate\Support\Str::limit($list->description, 80, $end='...') }}
                        </div>
                        <div class="card-footer d-flex ">
                            <div class="float-right">
                                @if($list->class_status=='STARTED')
                                    <a href="{{url('liveClass/goLive/'.$list->id)}}" class="btn btn-danger btn-sm text-default btn-w-lg"><i class="fa fa-video-camera"></i>  Join Now</a>
                                    <span class="text-danger text-bold ml-5 blink blink_me">Already Started</span>
                                @elseif($list->class_status=='NOT_STARTED' && $list->Remaining_Minutes>20)
                                    <a href="javascript:void(0)" class="btn btn-facebook btn-sm text-default btn-w-lg"><i class="fa fa-video-camera"></i>  Join Now</a>
                                @elseif($list->class_status=='NOT_STARTED' && $list->Remaining_Minutes<=20)
                                    <a href="{{url('liveClass/goLive/'.$list->id)}}" class="btn btn-success btn-sm text-default btn-w-lg"><i class="fa fa-video-camera"></i>  Join Now</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @if($tableList->count()==0)
                <div class="col-md-12 col-lg-12">
                    <div class="card ">
                        <div class="card-body text-center">
                            <img src="{{ URL::asset('user/images/404.jpg')}}" class=" align-self-center not-found-img" alt="branding logo"><br/>
                            <h3 class="font-large-2 my-1"> No Live Class Scheduled..</h3>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
@push('includeJs')

@endpush