@extends('layout.userMain')
@section('title','Bookmarks')
@section("content")
    <style>
        .card-img-top {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            height: 210px;
            object-fit: cover;
        }

    </style>
    <!-- Main content -->
    @php($backUrl='dashboard')
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="page-title">Bookmarks</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i
                                            class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Bookmarks</li>
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


            @if($current_affairs->total()>0)
                @php($colorKey=0)
                @foreach($current_affairs as $key=>$list)
                    <div class="col-md-12 col-lg-4">
                        <div class="card cursor-pointer">
                            <img class="card-img-top" src="{{uploads($list->image)}}"
                                 onerror="this.src='{{uploads('Uploads/default.jpg')}}'"   alt="Card image cap">

                            <div class="card-footer bt-0 pb-0 socialMediaShare">
                                <span class="text-muted">{{$list->date}}</span>
                                <div class="pull-right d-flex">
                                    <ul class="list-inline mb-0 bookmark-container">
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="bookmarked" data-id="{{$list->id}}" data-type="CurrentAffairs">
                                                <i class="fa fa-bookmark"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="dropdown socialMediaShare">
                                        <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-share"></i></button>
                                        <div class="dropdown-menu dropdown-grid">
                                            <a class="dropdown-item" href="https://www.facebook.com/sharer/sharer.php?u={{ url('currentAffairs?searchString='.$list->slug)}}&display=popup" target="_blank" data-action="share/whatsapp/share"><i class="fa fa-facebook-square fa-1x p-1"></i></a>
                                            <a class="dropdown-item" href="https://api.whatsapp.com/send?text={{ url('currentAffairs?searchString='.$list->slug)}}" target="_blank" data-action="share/whatsapp/share"><i class="fa fa-whatsapp fa-1x text-success p-1"></i></a>
                                            <a class="dropdown-item" href="http://pinterest.com/pin/create/button/?url={{ url('currentAffairs?searchString='.$list->slug)}}" target="_blank"><i class="fa fa fa-pinterest fa-1x text-danger p-1"></i></a>
                                            <a class="dropdown-item" href="https://twitter.com/intent/tweet?url={{ url('currentAffairs?searchString='.$list->slug)}}" target="_blank"><i class="fa fa-twitter-square fa-1x text-info p-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"> {{ \Illuminate\Support\Str::limit($list->title, 30, $end='...') }}</h5>
                                <p class="card-text current-affair-description {{$list->is_kannada}}"> {!! \Illuminate\Support\Str::limit(strip_tags($list->description), 80, $end='...') !!}</p>
                                    <a href="{{ url('bookmarks?searchString='.$list->slug)}}" class="text-danger anchor">Read More</a></p>
                            </div>
                            <div class="card-footer d-flex ">
                                @foreach($list->tag_array as $tag)
                                    <a href="{{url('bookmarks?searchTag='.$tag)}}" class="text-default"><span class="badge badge-pill mr-1 badge-dark">{{$tag}}</span></a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @php($colorKey=($colorKey==4)?0: $colorKey+1)
                @endforeach

                <div class="col-lg-12">
                    <div class="d-flex justify-content-center">
                        {!! $current_affairs->links() !!}
                    </div>
                </div>
            @else
                <div class="col-md-12 col-lg-12">
                    <div class="card ">
                        <div class="card-body text-center">
                            <img src="{{ URL::asset('user/images/404.jpg')}}" class=" align-self-center not-found-img" alt="branding logo"><br/>
                            <h3 class="font-large-2 my-1"> No Bookmarks Found!</h3>
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
            window.location.href='{{url('bookmarks')}}?searchString='+encodeURIComponent(searchString)
        });
        $('.card').on('click',function (e) {
            if (!$(e.target).closest('.socialMediaShare').length) {
                window.location = $(this).find(".anchor").first().attr("href");
            }
        });
        $('.bookmarked').on('click',function(e){ console.log($(this).find(''));
            var id=$(this).attr('data-id');
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                data: {
                    'id': id,
                    'type': $(this).attr('data-type'),
                },
                url: '{{url('bookmark')}}',
                dataType: 'json',
                context:this,
                success: function (data) {
                    $(this).find('i').toggleClass('fa fa-bookmark-o fa fa-bookmark')
                },
                error: function (data) { }
            });
        });
    </script>
@endpush