@extends('layout.adminMain')
@section("title","Test Series Sub Course")
@section('content')
    <div class="row mt-30">
        <div class="col-md-4">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <h3 class="card-title">Test Series Sub Course</h3>
                </div>
                <div class="card-body">
                    {{ Form::model($model,array('url'=>'/admin/specialTest/subCourse', 'method' => 'post', 'files' => true))}}
                    {{ Form::hidden('id',null) }}

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label>Special Test Course </label>
                                {{ Form::select('special_test_course_id',$specialTestCourses,null,['class'=>'select2-show-search required','required',"placeholder"=>"Special Test Course "])}}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Sub Course </label>
                                {{ Form::text('title',null,['class'=>'form-control required','placeholder'=>'Sub Course Name','required']) }}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label>Course Type</label>
                            <div class="custom-controls-stacked mt-10">
                                <label class="custom-control custom-radio">
                                    {{ Form::radio('type', 'Paid', true, array('class'=>'custom-control-input','onclick'=>"changeCourseType('Paid')")) }}
                                    <span class="custom-control-label">Paid</span>
                                </label>
                                <label class="custom-control custom-radio">
                                    {{ Form::radio('type', 'Free', false, array('class'=>'custom-control-input ','onclick'=>"changeCourseType('Free')")) }}
                                    <span class="custom-control-label">Free</span>
                                </label>

                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Course Amount</label>
                                {{ Form::text('amount',null,['class'=>'form-control isNumber required courseAmount','placeholder'=>'Course Amount','autocomplete'=>'off','required']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    @include('includes.save_update_button')
                </div>
                {{ Form::close() }}
            </div>
        </div>
        <div class="col-md-8">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <h3 class="card-title">Test Series Sub Course</h3>
                    <div class="card-options">
                        <div class="pull-right">
                            <a href="{{url('admin/specialTest/test/list')}}" class="btn btn-primary btn-icon text-white mr-2">
                                <span><i class="fe fe-plus"></i></span> Add Test
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="current_affairs" class="table table-striped table-bordered w-100">
                            <thead class="bg-blue">
                            <tr>
                                <th>#</th>
                                <th>Course</th>
                                <th>Sub Course</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($table_list as $array)
                                <tr>
                                    <td>{{ (($table_list->currentPage()-1)*$table_list->perPage())+$loop->iteration }}</td>
                                    <td> {{ $array['course']['course'] }}</td>
                                    <td> {{ $array['title'] }}</td>
                                    <td> {{ $array['type'] }}  </td>
                                    <td> {{ $array['amount'] }}</td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('specialTestSubCourse',['id'=>$array['id']])}}"
                                           class="table_icons" data-toggle="tooltip" data-original-title="Edit"><i
                                                    class="ti ti-pencil" aria-hidden="true"></i></a>
                                        <a href="{{ route('dynamicDelete',['modal'=>'SpecialTestSubCourse','id'=>$array['id']]) }}"
                                           class="table_icons confirm-delete" data-toggle="tooltip"
                                           data-original-title="Delete"><i class="ti ti-trash"
                                                                           aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {!! $table_list->links() !!}
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection

@push('includeJs')
    @include('includes.CssJs.advanced_form')
    @include('includes.CssJs.dataTable')
    <script>
        let courseType = '{{$model['type']}}'
        if (courseType !== '') changeCourseType(courseType);

        function changeCourseType(type) {
            if (type === 'Free') {
                $('.courseAmount').attr('readonly', true)
                $('.courseAmount').val(0)
            } else {
                $("input[name=amount]").removeAttr('readonly', true)
            }

        }
    </script>
@endpush
