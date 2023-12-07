@extends('layout.userMain')
@section('title','Video Material')
@section("content")
    <style>
        .hover-box {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 1px 10px;
            background: rgba(34, 34, 34, 0.8);
            transition: all 0.2s ease-in-out;
            -moz-transition: all 0.2s ease-in-out;
            -webkit-transition: all 0.2s ease-in-out;
            -o-transition: all 0.2s ease-in-out;

        }
        .card-body{
            position: relative;
            padding: 0;
        }

        .hover-box a, .post-tags {
            color: #ffff !important;
            font-size: 12px;
        }
        .card-img-top {
            object-fit: cover;
            height: 200px;
        }
    </style>
    <!-- Main content -->
    @php($backUrl='dashboard')
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="page-title">Video Material</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i   class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="{{url('/videoMaterials')}}">Video Material</a></li>

                        </ol>
                    </nav>

                </div>
            </div>
            <div class="float-right mr-10">
                <div class="input-group input-search">
                    <div class="input-group-append">
                        <button id="datepicker" class="btn btn-date bg-white" type="submit" id="button-addon3"><i class="ti ti-calendar"></i></button>
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

        <div class="row ">


            @if($data->total()>0)
                @php($colorKey=0)
                @foreach($data as $key=>$list)
                    @php( $video_id = explode("?v=",$list->youtube_url))

                    <div class="col-md-12 col-lg-4">

                        <div class="card cursor-pointer column pull-up playVideo" videoUrl='{{$list->youtube_url}}'>
                            <div class="card-body">
                            <img class="card-img-top" src="https://img.youtube.com/vi/{{$video_id[1]}}/mqdefault.jpg"
                                 onerror="this.src='{{uploads('Uploads/default.jpg')}}'"   alt="Card image cap">
                            <div class="hover-box">

                                    <a >{{ $list->title }}</a>
                               <br/>
                                <span class="post-tags">
                                   <i class="fa fa-clock-o"></i> {{$list->date}}
                                </span>
                            </div>
                            </div>
                            <div class="card-footer d-flex ">
                                @foreach($list->tag_array as $tag)
                                    <a href="{{url('videoMaterials?searchTag='.$tag)}}" class="text-default"><span class="badge badge-pill mr-1 badge-dark">{{$tag}}</span></a>
                                @endforeach

                            </div>
                        </div>


                    </div>
                    @php($colorKey=($colorKey==4)?0: $colorKey+1)
                @endforeach

                <div class="col-lg-12">
                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center">

                        {!! $data->links() !!}
                    </div>
                </div>
                <div class="modal fade" id="video-popup-0">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">×</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="pittube-video">
                                    <div class="video-frame">


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            @else

                <div class="col-md-12 col-lg-12">
                    <div class="card ">

                        <div class="card-body text-center">
                            <img src="{{ URL::asset('user/images/404.jpg')}}" class=" align-self-center not-found-img" alt="branding logo"><br/>

                            <h3 class="font-large-2 my-1"> No Study Material Found!</h3>


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
        $('.searchAnnouncement').on('click',function () {
            let searchString=$('#search-input').val()
            window.location.href='{{url('videoMaterials')}}?searchString='+encodeURIComponent(searchString)
        })

    </script>
@endpush
