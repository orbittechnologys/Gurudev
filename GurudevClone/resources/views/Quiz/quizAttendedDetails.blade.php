@extends('layout.adminMain')
@section("title","Quiz Attended Details")
@section('additionalHeaderAssets')
    @include('includes.CssJs.table-export-btn')

    @include('includes.CssJs.advanced_form')
@endsection

@section('content')
    <style>
        .card-bg {
            border: 1px solid #3f51b5;
            border-radius: 10px;
        }

    </style>
        @include('includes.Print.print_quiz_attended')
    <div class="content-body fadeOutRight">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10  mt-30">
                <div class="card card-bg mb-20">
                    <div class="card-body pt-20 pb-10">

                        <h5>Quiz Title : {{ $detail_list[0]['quiz']['quiz_name'] }} </h5>

                        <div class="row mt-30">
                            <div class="col-md-4">
                                <h6>Total Questions : {{ $detail_list[0]['quiz']['total_questions'] }} </h6>
                            </div>
                            <div class="col-md-4">
                                <h6>Total Time : {{ $detail_list[0]['quiz']['total_time'] }} </h6>
                            </div>
                            <div class="col-md-4 ">
                                <h6 class="pull-right">Publish Date :
                                    {{ date('d M Y', strtotime($detail_list[0]['quiz']['publish_date'])) }} </h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="table-responsive card-body">
                        <table class="table table-hover table-striped table-bordered quiz_table">
                            <thead>
                                <tr class="bg-blue">
                                    <th>Rank</th>
                                    <th>User Name</th>
                                    <th>Time Taken</th>
                                    <th>Attended Question</th>
                                    <th>Total Marks</th>
                                    <th>Obtained Marks</th>
                                    <th>Neg Marks</th>
                                    <th>Final Marks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detail_list as $list)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $list['user']['name'] }}</td>
                                        <td>{{ $list['total_time_taken'] }}</td>
                                        <td>{{ $list['total_question_attended'] }}</td>
                                        <td>{{ $list['total_marks'] }}</td>
                                        <td>{{ $list['obtained_marks'] + $list['negative_marks'] }}</td>
                                        <td>{{ $list['negative_marks'] }}</td>
                                        <td>{{ $list['obtained_marks'] }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="row mb-30">
                            <div class="col-lg-12">
                                {{-- Pagination --}}
                                <div class="d-flex justify-content-center">

                                    {!! $detail_list->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <a class="fixed-bottom-right" href="javascript:window.history.back()">
        <i class="fa fa-arrow-left fa-2x"></i>
    </a>
@endsection
@section('additionalAssets')
    <script>
        // $('#questions_load').load('{{ url('/questions/0/0/0') }}');

        function myPagination(page, url = null) {
            if (url) {
                split_str = page.split('=');
                page = split_str[1];
            }
            // console.log(page);
            window.location.href = '{{ url('/quiz/getAttendedDetails') }}/' +
                {{ $detail_list['data'][0]['question_allocation_id'] }} + '?page=' + page;
        }
    </script>
@endsection
