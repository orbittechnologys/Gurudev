@extends('layout.userMain')
@section('title', 'Weekly Buzz')
@section('content')
    <style>
        .card-img-new {

            width: 430px;
            height: 300px;
            object-fit: contain;

        }
        .cursor-pointer{
            cursor: pointer;
        }

        .card-title {
            font-weight: 500;
        }

        .border-top-0 {
            border-top: 4px solid #2e8d71 !important;
        }

        .btnclr-0 {
            background: #2e8d71 !important;
            border-color: #2e8d71;
        }

        .border-top-1 {
            border-top: 4px solid #4a8dc3;
        }

        .btnclr-1 {
            background: #4a8dc3 !important;
            border-color: #4a8dc3;
        }

        .border-top-2 {
            border-top: 4px solid #c5512e;
        }

        .btnclr-2 {
            background: #c5512e !important;
            border-color: #c5512e;
        }

        .border-top-3 {
            border-top: 4px solid #847818;
        }

        .btnclr-3 {
            background: #847818 !important;
            border-color: #847818;
        }

        /* .border-top-4{
                    border-top: 4px solid #6f42c1;
                }
                .btnclr-4{
                    background:  #6f42c1!important;
                    border-color: #6f42c1;
                } */
    </style>
    <!-- Main content -->
    @php($backUrl = 'dashboard')
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="page-title">E Magazine</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}"><i
                                        class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">><a href="{{ url('/weeklyBuzz') }}">E
                                    Magazine</a></li>

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
                    <div class="col-md-12 col-lg-3">

                            <div onclick=openFolder("{{ url('weeklyBuzz?folder_id=').$list->id }}") class="card cursor-pointer column pull-up border-top-{{ $colorKey }}">
                                  <div class="card-header">
                                        <div class="card-title"> {{ $list->folder_name }}</div>
                                        <div class="card-options">
                                            <div class="pull-right">
                                                <a href="javascript:void(0)" style="width: 40px;" data-toggle="tooltip" data-original-title="Weekly Buzz"
                                                    class="btn btnclr-{{ $colorKey }} btn-sm btn-rounded text-white mr-2">
                                                    <span>{{ $list->count }}</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                            </div>

                    </div>

                    @php($colorKey = $colorKey == 3 ? 0 : $colorKey + 1)
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
            window.location.href = '{{ url('weeklyBuzz') }}?searchString=' + encodeURIComponent(searchString)
        })
        function openFolder(url){
            window.location.href =url
        }
    </script>
@endpush
