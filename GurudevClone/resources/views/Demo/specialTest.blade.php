@extends('layout.userMain')

@section("content")
    <style>

  .card-test-count{
      position: absolute;
      right: 8px;
      top: 15px;
      font-size: 15px;
  }

    </style>
	<!-- Main content -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="page-title">Special Test -2021</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Special Test</li>


                        </ol>
                    </nav>
                </div>
            </div>

        </div>
    </div>
	<section class="content">

		<div class="row">

                @php($month=0)
                @php($border=["info","success","danger","warning"])
                @php($borderCount=0)
                @for($i=0;$i<12;$i++)
                @php($month++)
                @if($month==13) @php($month=1) @endif
                @if($borderCount==4) @php($borderCount=0) @endif

                    <div class="col-lg-4 col-12">
                        <div class="box mb-15 pull-up border-{{$border[$borderCount]}} b-1">
                            <div class="box-body p-2">
                                <div class="d-flex align-items-center  justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-15  rounded text-center">
                                            <span class=" w-20 pl-2 pr-2  font-size-24 text-{{$border[$borderCount++]}}"><i class="fa fa-calendar"></i> </span>
                                        </div>
                                        <div class="d-flex flex-column font-weight-500">
                                            <a href="{{url('/specialTest/test1')}}" class="text-dark hover-primary mb-1 font-size-16">{{date('F', mktime(0, 0, 0, $month, 10))}} 2021
                                                <span class="font-size-14 card-test-count">35 Tests </span></a>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endfor


		</div>
		<!-- /.row -->


	</section>


@endsection