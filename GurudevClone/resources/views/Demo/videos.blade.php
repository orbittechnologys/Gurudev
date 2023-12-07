@extends('layout.userMain')

@section("content")
    {{ Html::style("user/css/mcq.css") }}
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
                <h3 class="page-title">Videos</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Videos</li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>
    </div>
	<section class="content">

		<div class="row fx-element-overlay">
                @for($i=1;$i<4;$i++)

                <div class="col-lg-3 col-md-6 col-12">
                    <div class="box">
                        <div class="fx-card-item">
                            <div class="fx-card-avatar fx-overlay-1"><img src="{{URL::asset('images/4.jpg')}}" alt="user"
                                                                          class="bbrr-0 bblr-0">
                                <div class="fx-overlay">
                                    <ul class="fx-info">
                                        <li><a class="btn btn-danger no-border" data-toggle="modal" data-target="#video-popup" href="javascript:void(0);">Play</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="fx-card-content">
                                <h4 class="box-title mb-0">Manegement</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="box">
                        <div class="fx-card-item">
                            <div class="fx-card-avatar fx-overlay-1"><img src="{{URL::asset('images/8.jpg')}}" alt="user"
                                                                          class="bbrr-0 bblr-0">
                                <div class="fx-overlay">
                                    <ul class="fx-info">
                                        <li><a class="btn btn-danger no-border"  data-toggle="modal" data-target="#video-popup" href="javascript:void(0);">Play</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="fx-card-content">
                                <h4 class="box-title mb-0">Networking</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="box">
                        <div class="fx-card-item">
                            <div class="fx-card-avatar fx-overlay-1"><img src="{{URL::asset('images/2.jpg')}}" alt="user"
                                                                          class="bbrr-0 bblr-0">
                                <div class="fx-overlay">
                                    <ul class="fx-info">
                                        <li><a class="btn btn-danger no-border"  data-toggle="modal" data-target="#video-popup" href="javascript:void(0);">Play</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="fx-card-content">
                                <h4 class="box-title mb-0">Security</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="box">
                        <div class="fx-card-item">
                            <div class="fx-card-avatar fx-overlay-1"><img src="{{URL::asset('images/1.jpg')}}" alt="user"
                                                                          class="bbrr-0 bblr-0">
                                <div class="fx-overlay">
                                    <ul class="fx-info">
                                        <li><a class="btn btn-danger no-border"  data-toggle="modal" data-target="#video-popup" href="javascript:void(0);">Play</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="fx-card-content">
                                <h4 class="box-title mb-0">Language</h4>
                            </div>
                        </div>
                    </div>
                </div>

                @endfor


		</div>
		<!-- /.row -->


	</section>


@endsection