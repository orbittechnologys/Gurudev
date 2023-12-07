@extends('layout.userMain')
@section('title','Subjects')
@section("content")
    <style>


        .badge{
            width:47px;
        }

    </style>
    @php($backUrl='course')
    <!-- Main content -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="page-title">Subjects</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i
                                            class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="{{url('/course')}}">Course</a></li>
                            <li class="breadcrumb-item" aria-current="page">Subject</li>

                        </ol>
                    </nav>
                </div>
            </div>

        </div>
    </div>
    <section class="content">
        <div class="row">

            @php($k=1)
            @foreach($data as $list)
                <?php if ($k == 4) $k = 1; ?>
                <div class="col-lg-4 col-md-4 col-12">
                        <div class="box bg-img ribbon-box subject-side-badge pointer"
                             style="background-image: url('{{asset('user/images/abstract-'.$k++.'.svg')}}');background-position: right top; background-size: 30% auto;"
                             onclick="course_meterial_detail(this,{{$list['id']}})">
                            <div class="card-body pb-2">
                                <div class="h-60">
                                    <a href="{{url('course/subject/'.$list->slug)}}" class="h-10 box-title font-weight-600 text-muted hover-primary font-size-18">{{ $list->subject }}</a>
                                </div>
                                <div style="display: grid" >
                                    <div>
                                        <div class="float-right">
                                            <h5 class="badge badge-pill badge-danger">{{$list->chapterCount->chapterCount+0}}</h5>
                                        </div>
                                        <div class="float-left mt-1">
                                            <h6>Total Materials </h6>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="float-right">
                                            <h5 class="badge badge-pill badge-success">{{$list->quizCount->quizCount+0}}</h5>
                                        </div>
                                        <div class="float-left mt-1">
                                            <h6>Total Quiz </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            @endforeach


        </div>
    </section>
@endsection
@push('includeJs')
    <script>

        $('.box').on('click',function (e) {
            window.location = $(this).find(".box-title").first().attr("href");
        })

    </script>
@endpush