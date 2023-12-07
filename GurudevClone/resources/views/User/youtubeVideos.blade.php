@extends('layout.userMain')
@section('title', 'Weekly Buzz')
@section('content')
    <style>
        .card-img-new {

            width: 430px;
            height: 300px;
            object-fit: contain;

        }
        .card-title{
            font-weight: 500;
        }



.video-js {
    background-color: #000;
    position: relative;
    padding: 0;
    width: 100%;
}
.vjs-loading-spinner {
    display: none!important;
}

    </style>
    <!-- Main content -->
    @php($backUrl = 'dashboard')
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="page-title">YouTube Videos</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}"><i
                                        class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">><a href="{{ url('/youtubeVideos') }}">YouTube Videos</a></li>

                        </ol>
                    </nav>

                </div>
            </div>
            <div class="float-right mr-10">
                <div class="input-group input-search">
                    <div class="input-group-append">
                        <button id="datepicker" class="btn btn-date bg-white" type="submit" id="button-addon3"><i
                                class="ti ti-calendar"></i></button>

                    </div>
                    <input class="form-control" value="{{ app('request')->input('searchString') }}" id="search-input"
                        placeholder="Search">
                    <div class="input-group-append">

                        <a href="javascript:void(0)" class="btn btn-search bg-primary-light searchAnnouncement"
                            type="submit" id="button-addon3"><i class="ti-search"></i></a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <section class="content">

        <div class="row match-height">


            @if ($data->total() > 0)
                @php($colorKey = 0)
                @foreach ($data as $key => $list)
                    <div class="col-md-12 col-lg-4">
                        <div class="card cursor-pointer column" >
                            <div class="card-header">
                                <div class="card-title"> {{ $list->title }} <br/> <span class="text-muted">{{$list->date}}</span></div>

                            </div>
                            <div class="card-body p-1" data-id="{{ $list->link }}" >
                                <video
                                id="vid{{$key}}"
                                class="video-js vjs-default-skin"
                                controls
                                width="640" height="238"
                                data-setup='{ "techOrder": ["youtube", "html5"], "sources": [{ "type": "video/youtube", "src": "https://www.youtube.com/watch?v={{ $list->link }}"}] }'
                              >
                              </video>


                            </div>

                        </div>
                    </div>

                    @php($colorKey = $colorKey == 4 ? 0 : $colorKey + 1)
                @endforeach

                <div class="col-lg-12">
                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center">

                        {!! $data->links() !!}
                    </div>
                </div>
            @else
                <div class="col-md-12 col-lg-12">
                    <div class="card ">

                        <div class="card-body text-center">
                            <img src="{{ URL::asset('user/images/404.jpg') }}" class=" align-self-center not-found-img"
                                alt="branding logo"><br />

                            <h3 class="font-large-2 my-1"> No Videos!</h3>


                        </div>

                    </div>
                </div>
            @endif


        </div>
        <!-- /.row -->


    </section>


@endsection
@push('includeJs')
{!! Html::style("user/assets/vendor_plugins/VideoJS/video-js.min.css");!!}
{!! Html::script("user/assets/vendor_plugins/VideoJS/video.js");!!}
{!! Html::script("user/assets/vendor_plugins/VideoJS/youtube.js");!!}
    <script>
        $('.searchAnnouncement').on('click', function() {
            let searchString = $('#search-input').val()
            window.location.href = '{{ url('youtubeVideos') }}?searchString=' + encodeURIComponent(searchString)
        })
    </script>
@endpush
