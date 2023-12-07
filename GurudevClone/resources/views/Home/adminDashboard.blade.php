@extends('layout.adminMain')
@section('title','Dashboard')
@section('content')
        @if(Auth::guard('admin')->user()->user_name=='superadmin' || Auth::guard('admin')->user()->user_name=='admin')

        <div class="row mt-30">
            <div class="col-xl-3 col-lg-3 col-md-12">
                <div class="card pointer" onclick="redirectUser('Quiz')">
                    <div class="card-header pt-2 pb-0 border-bottom-0">
                        <h6 class="mb-0">Total no of Users</h6>
                        <div class="card-options">
                            <i class="fe fe-user-check fs-20 text-primary"></i>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <h2 class=" mb-2 ">
                            <span class="number-font">{{$totUsers}}</span>

                        </h2>
                        <div class="progress h-1 mb-0">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary w-60" role="progressbar"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12">
                <div class="card pointer" onclick="redirectUser('Mock')">
                    <div class="card-header pt-2 pb-0 border-bottom-0">
                        <h6 class="mb-0">Total no of  Course</h6>
                        <div class="card-options">
                            <i class="fe fe-book text-secondary fs-20"></i>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <h2 class=" mb-2 ">
                            <span class="number-font">{{$totCourse}}</span>

                        </h2>
                        <div class="progress h-1 mb-0">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-secondary w-60" role="progressbar"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12">
                <div class="card pointer" onclick="redirectUser('CourseMaterials')">
                    <div class="card-header pt-2 pb-0 border-bottom-0">
                        <h6 class="mb-0"> Total Amount Collected</h6>
                        <div class="card-options">
                            <i class="fa fa-rupee fs-20 text-success"></i>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <h2 class=" mb-2 ">
                            <span class="number-font">{{$totAmtCollect}}</span>

                        </h2>
                        <div class="progress h-1 mb-0">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success w-60" role="progressbar"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12">
                <div class="card pointer" onclick="redirectUser('QuestionBank')">
                    <div class="card-header pt-2 pb-0 border-bottom-0">
                        <h6 class="mb-0">Total Current Affairs</h6>
                        <div class="card-options">
                            <i class="fe fe-calendar text-danger fs-20"></i>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <h2 class=" mb-2 ">
                            {{$currentAffairs}}

                        </h2>
                        <div class="progress h-1 mb-0">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger w-60" role="progressbar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
@endsection

@section('additionalAssets')
    <style>
        .chart-wrapper {
            position: relative;
            padding-bottom: 40%;
        }

        .chart-inner {
            position: absolute;
            width: 100%; height: 100%;
        }
    </style>
{{--    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-3d.js"></script>
    <script src="https://code.highcharts.com/modules/cylinder.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>--}}
@endsection

