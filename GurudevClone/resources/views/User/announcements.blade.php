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
    @php($backUrl='dashboard')
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="page-title">Announcements</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i class="mdi mdi-home-outline"></i></a></li>

                            <li class="breadcrumb-item" aria-current="page">Announcements</li>
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
        <div class="row">
            @if($announcement->total()>0)
                @php($colorKey=0)
                @foreach($announcement as $key=>$list)
                    <?php if($list->attachment!='') $list['attachment']=uploads($list->attachment); ?>
                    <?php if($list->pdf!='') $list['pdf']=uploads($list->pdf); ?>
                    <div class="col-xl-4 col-12">
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
                                        <a href="javascript:void(0)"  data-content="{{$list}}"
                                           class="text-danger announcementReadMore">Read More</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php($colorKey=($colorKey==5)?0: $colorKey+1)
                @endforeach

                <div class="col-lg-12">
                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center">
                        {!! $announcement->onEachSide(0)->links() !!}
                    </div>
                </div>

            @else

                <div class="col-md-12 col-lg-12">
                    <div class="card ">

                        <div class="card-body text-center">
                            <img src="{{ URL::asset('user/images/404.jpg')}}" class=" align-self-center not-found-img" alt="branding logo"><br/>

                            <h1 class="font-large-2 my-1"> No Record Found!</h1>


                        </div>

                    </div>
                </div>
            @endif
        </div>
    </section>


@endsection
@push('includeJs')
    <script>
        $('.searchAnnouncement').on('click',function () {
            let searchString=$('#search-input').val()
            window.location.href='{{url('announcements')}}?searchString='+encodeURIComponent(searchString)
        })
    </script>
@endpush