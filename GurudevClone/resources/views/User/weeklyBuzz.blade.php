@extends('layout.userMain')
@section('title', 'Weekly Buzz')
@section('content')
    <style>
        .card-img-new {

            width: 100%;
            height: 300px;
            object-fit: contain;

        }
        .card-title{
            font-weight: 500;
        }

    </style>
    <!-- Main content -->
    @php($backUrl = 'weeklyBuzz/folder')
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="page-title">E Magazine</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}"><i
                                        class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">><a href="{{ url('/weeklyBuzz') }}">E Magazine</a></li>

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
                        <div class="card cursor-pointer column pull-up " >
                            <div class="card-header">
                                <div class="card-title"> {{ $list->title }} <br/> <span class="text-muted">{{$list->date}}</span></div>
                                <div class="card-options">
                                    <div class="pull-right">
                                        <a href="{{ uploads($list->attachment) }}" download="download" data-toggle="tooltip"
                                            data-original-title="Weekly Buzz"
                                            class="btn btn-info btn-sm btn-rounded text-white mr-2">
                                            <span><i class="fa fa-download"></i></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-1">
                                <img class="card-img-new" src="{{ uploads($list->thumbnail) }}"
                                    onerror="this.src='{{ uploads('Uploads/default.jpg') }}'" alt="Card image cap">

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
                            <img src="{{ asset('user/images/404.jpg') }}" class=" align-self-center not-found-img"
                                alt="branding logo"><br />

                            <h3 class="font-large-2 my-1"> No E Magazine Found!</h3>


                        </div>

                    </div>
                </div>
            @endif


        </div>
        <!-- /.row -->


    </section>


@endsection
@push('includeJs')
    <script>
        $('.searchAnnouncement').on('click', function() {
            let searchString = $('#search-input').val()
            window.location.href = '{{ url('weeklyBuzz') }}?folder_id={{$folder_id}}&searchString=' + encodeURIComponent(searchString)
        })
    </script>
@endpush
