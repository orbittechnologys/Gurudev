@extends('layout.userMain')
@section('title', 'Study Material')
@section('content')
    <style>

    </style>
    <!-- Main content -->
    @php($backUrl = 'dashboard')
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="page-title">Study Material</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}"><i
                                        class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">><a href="{{ url('/studyMaterials') }}">Study
                                    Material</a></li>

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
                        <div class="card cursor-pointer column bt-2 pull-up border-danger">
                            <div class="card-footer d-flex justify-content-between bt-0 pb-0">
                                <span class="text-muted">{{ $list->date }}</span>
                                @if ($list->material != '' )
                                    <ul class="list-inline mb-0">
                                        <li class="list-inline-item">
                                            <a href="{{ uploads($list->material) }}" download="download">
                                                <i class="fa fa-download "></i>
                                            </a>
                                        </li>
                                    </ul>
                                @endif
                            </div>

                            <div class="card-body">
                                <h5 class="card-title"> {{ $list->title }}</h5>

                            </div>
                            <div class="card-footer d-flex ">
                                @foreach ($list->tag_array as $tag)
                                    <a href="{{ url('studyMaterials?searchTag=' . $tag) }}" class="text-default"><span
                                            class="badge badge-pill mr-1 badge-dark">{{ $tag }}</span></a>
                                @endforeach

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
    <script>
        $('.searchAnnouncement').on('click', function() {
            let searchString = $('#search-input').val()
            window.location.href = '{{ url('studyMaterials') }}?searchString=' + encodeURIComponent(searchString)
        })
    </script>
@endpush
