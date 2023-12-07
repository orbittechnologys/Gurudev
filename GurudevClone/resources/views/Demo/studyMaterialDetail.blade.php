@extends('layout.userMain')

@section("content")
    <style>

        .card-bookmark{
            position: absolute;
            top: 20px;
            right: 10px;
        }

    </style>
	<!-- Main content -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="page-title">Study Material January 2021 </h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Study Material</li>
                            <li class="breadcrumb-item" aria-current="page">Study Material </li>


                        </ol>
                    </nav>
                </div>
            </div>

        </div>
    </div>
	<section class="content">

		<div class="row">


                @php($color=["info","success","danger"])
                @php($images=["temple","bubbles","brick"])

                @php($count=0)
                @for($i=0;$i<12;$i++)
                @if($count==3) @php($count=0) @endif

                <div class="col-xl-4" data-toggle="tooltip" data-placement="top" title="Click to Download Material">
                    <a href="{{asset('Uploads/gurudeve.pdf')}}" download="download" class="box  bg-{{$color[$count]}} bg-hover-info bg-{{$images[$count++]}}-dark">
                        <div class="box-body">
                            <div type="button" class="card-bookmark"> <span class="text-white fa fa-bookmark-o font-size-20"><span class="path1"></span><span class="path2"></span></span></div>
                            <span class="text-white icon-File-cloud font-size-40"><span class="path1"></span><span class="path2"></span></span>
                            <div class="text-white font-weight-600 font-size-18 mb-2 mt-5">Study Material</div>
                            <div class="text-white font-size-16"><i class="fa fa-calendar"></i> 21-2-2021
                                <span class="float-right"> <i class="fa fa-file"></i> 2 MB </span></div>

                        </div>
                    </a>
                </div>
                @endfor


		</div>
		<!-- /.row -->


	</section>


@endsection