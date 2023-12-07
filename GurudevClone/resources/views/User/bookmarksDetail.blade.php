@extends('layout.userMain')

@push('includeMeta')
    <!--  Essential META Tags -->
    <meta property="og:title" content="{{$currentAffair->title}}">
    <meta property="og:type" content="article"/>
    <meta property="og:description" content="{{$currentAffair->description}}">
    <meta property="og:image" content="{{uploads($currentAffair->image)}}">
    <meta property="og:url" content="{{Request::url() }}">
    <meta property="og:site_name" content="Gurudev Academy">
    @endpush
@section("title",$currentAffair->title)
@section("content")


    @php($backUrl='currentAffairs')
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="page-title">Bookmarks</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="{{url('/currentAffairs')}}">Current Affair</a></li>
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
            <div class="col-lg-8 col-md-9 col-12">
                <div class="card">
                    <img class="card-img-top" style="max-height: 350px" src="{{uploads($currentAffair->image)}}"
                         onerror="this.src='{{uploads('Uploads/default.jpg')}}'"  alt="Card image cap">

                    <div class="card-footer d-flex justify-content-between bt-0 pb-0">
                        <div>
                            <div class="text-muted"><b>Date :</b> {{$currentAffair->date}}</div>
                            <div class="text-muted"><b>Source :</b><span class="text-danger">{{$currentAffair->source}}</span> </div>
                        </div>
                        <div class="pull-right d-flex">
                            <ul class="list-inline mb-0 bookmark-container">
                                <li class="list-inline-item">
                                    <a href="javascript:void(0)" class="bookmarked" data-id="{{$currentAffair->id}}" data-type="CurrentAffairs">
                                        <i class="fa fa-bookmark"></i>
                                    </a>
                                </li>
                            </ul>
                            <div class="dropdown socialMediaShare">
                                <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-share"></i></button>
                                <div class="dropdown-menu dropdown-grid">
                                    <a class="dropdown-item" href="https://www.facebook.com/sharer/sharer.php?u={{ url('currentAffairs?searchString='.$currentAffair->slug)}}&display=popup" target="_blank" data-action="share/whatsapp/share"><i class="fa fa-facebook-square fa-1x p-1"></i></a>
                                    <a class="dropdown-item" href="https://api.whatsapp.com/send?text={{ url('currentAffairs?searchString='.$currentAffair->slug)}}" target="_blank" data-action="share/whatsapp/share"><i class="fa fa-whatsapp fa-1x text-success p-1"></i></a>
                                    <a class="dropdown-item" href="http://pinterest.com/pin/create/button/?url={{ url('currentAffairs?searchString='.$currentAffair->slug)}}" target="_blank"><i class="fa fa fa-pinterest fa-1x text-danger p-1"></i></a>
                                    <a class="dropdown-item" href="https://twitter.com/intent/tweet?url={{ url('currentAffairs?searchString='.$currentAffair->slug)}}" target="_blank"><i class="fa fa-twitter-square fa-1x text-info p-1"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <h4 class="card-title">{!!$currentAffair->title!!}</h4>
                        <div class="card-text">
                            <div id="content-body-14269002-36077547">
                                <p class="text-muted text-justify">{!!$currentAffair->description!!}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex ">
                        @foreach($currentAffair->tag_array as $tag)
                        <a href="{{url('bookmarks?searchTag='.$tag)}}" class="text-default"><span class="badge badge-pill mr-1 badge-dark">{{$tag}}</span></a>
                        @endforeach

                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-3 col-12">
                <div class="box no-shadow mb-0 bg-transparent ">
                    <div class="box-header no-border px-0">
                        <h4 class="box-title">Related Current Affairs </h4>
                    </div>
                </div>
                <div>
                    @foreach($relatedNews as $list)
                        <div class="box mb-15 pull-up related_current_affairs">
                            <div class="box-body p-15">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-15 bg-warning-light h-50 w-50 l-h-60 rounded text-center">
                                            <img src="{{uploads($list['image'])}}"
                                                 onerror="this.src='{{uploads('Uploads/default.jpg')}}'" class="h-50" />
                                        </div>
                                        <div class="d-flex flex-column font-weight-500">
                                            <a href="{{ url('bookmarks?searchString='.$list['slug'])}}" class="text-dark hover-primary mb-1 font-size-12">{{ \Illuminate\Support\Str::limit($list['title'], 30, $end='...') }}..</a>
                                            <span class="text-fade font-size-10">{{$list['date']}}</span>
                                        </div>
                                    </div>
                                    <a href="{{ url('bookmarks?searchString='.$list['slug'])}}">
                                        <span class="icon-Arrow-right font-size-24"><span class="path1"></span><span class="path2"></span></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
@push('includeJs')
    <script>
        $('.searchAnnouncement').on('click',function () {
            let searchString=$('#search-input').val()
            window.location.href='{{url('bookmarks')}}?searchString='+encodeURIComponent(searchString)
        })
        $('.bookmarked').on('click',function(e){
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