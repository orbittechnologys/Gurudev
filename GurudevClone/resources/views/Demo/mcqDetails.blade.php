@extends('layout.userMain')

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
                <h3 class="page-title">Mock Test January-2021</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="{{url('/mcq')}}">Mock Test</a></li>
                            <li class="breadcrumb-item" aria-current="page">Mock Test</li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>
    </div>
	<section class="content">

		<div class="row mcq-details">


                @php($border=["info","success","danger","warning"])
                @php($borderCount=0)
                @for($i=1;$i<11;$i++)
                @if($borderCount==3) @php($borderCount=0) @endif

                <div class="col-xl-4 col-12">
                    <div class="box bl-2 border-{{$border[++$borderCount]}} rounded pull-up">
                        <div class="box-body">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center pr-2 justify-content-between">
                                    <h4 class="font-weight-500">
                                        Common English
                                    </h4>
                                </div>
                                <p class="font-size-16">
                                   <span> <i class="fa fa-question-circle-o"></i> 20 Question</span>
                                    <span class="float-right"> <i class="fa fa-clock-o-circle-o"></i> 60 Minutes</span>
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
                @endfor


		</div>
		<!-- /.row -->


	</section>


@endsection