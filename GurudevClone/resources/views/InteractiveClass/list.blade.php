@extends('layout.adminMain')
@section("title","Live Class")
@section('content')
    <div class="row mt-30">
        <div class="col-md-12">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <h3 class="card-title">Live Class List</h3>
                     <div class="card-options pull-right">
                        <a class="btn btn-primary" href="{{ url('admin/liveClass/create') }}">Create Live Class</a>
                    </div>
                    
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table  id="exportTable" class="table table-striped table-bordered w-100">
                            <thead class="text-nowrap bg-blue">
                            <tr>
                                <th>#</th>
                                <th>Batch</th>
                                <th>Title</th>
                                <th>Start @</th>
                                <th>Ends @</th>

                                <th>Duration</th>

                                <th>Description</th>
                                <th>Status</th>
                                <th>Room Id</th>
                                {{--<th>Password</th>--}}
                                <th>Action</th>

                            </tr>
                            </thead>
                            <tbody>

                            @foreach($meeting_list as $list)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $list['batch']['batch']}}</td>
                                    <td class="text-wrap">{{$list['title']}}</td>
                                    <td><?php echo date('d-M-Y h:i A',strtotime($list['start_time'])); ?></td>
                                    <td><?php echo date('d-M-Y h:i A',strtotime($list['end_time'])); ?></td>

                                    <td >{{ $list['duration'] }}</td>

                                    <td>{{ $list['description'] }}</td>
                                    <td>{{ $list['status'] }}</td>
                                    <td>{{ $list['meeting_id'] }}</td>
                                    {{--<td>{{ $list['password'] }}</td>--}}
                                    <td>
                                        <a href="{{ route('liveClass.edit',['id'=>$list['id']])}}" class="table_icons" data-toggle="tooltip" data-original-title="Edit"><i class="ti ti-pencil" aria-hidden="true"></i></a>
                                        <a href="{{ route('dynamicDelete',['modal'=>'LiveClass','id'=>$list['id']]) }}" class="table_icons confirm-delete" data-toggle="tooltip" data-original-title="Delete" ><i class="ti ti-trash" aria-hidden="true"></i></a>
                                          <a href="{{ url('admin/liveClass/goLive')}}/{{$list['id']}}" target="_blank" class="table_icons" data-toggle="tooltip" data-original-title="Go Live"><i class="fa  fa-video-camera" aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" onclick="showStudents({{$list['id']}})" class="table_icons" data-toggle="tooltip" data-original-title="Login Student Details" ><i class="fa fa-users" aria-hidden="true"></i></a>
                                    </td>

                                </tr>
                            @endforeach
                           
                            </tbody>

                        </table>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="studentList" class="modal fade" role="dialog">
        <div class="modal-dialog model-center">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Student List</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>
                <div class="modal-body" style="overflow-y: scroll; max-height: 500px">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('includeJs')
    @include('includes.CssJs.dataTable')
    <script>
        function showStudents(id){
            $('.modal-body').load('{{ url('admin/liveClass/attendedStudent/') }}/'+id,function(){
                $('#studentList').modal('show');
            });
        }
    $('#exportTable').DataTable({
		'paging'      : true,
		'searching'   : true,
		'lengthChange': true,
		'ordering'    : true,
		'info'        : true,
		'responsive': false,
		'autoWidth'   : true,
		 "dom" : "<'row row_br'<'col-lg-4 col-md-4 col-sm-12'B>" +
                "<'col-lg-4 col-md-4 col-sm-12'l>" +
                "<'col-lg-4 col-md-4 col-sm-12'f>>"+
                "<'row'<'col-sm-12't>>" +
                "<'row'<'col-sm-6'><'col-sm-6'p>>",
		buttons: [{
		    extend: 'excel',
            title: 'Gurudev Academy Live Class List',
            className: 'btn  btn-info',
        }],
		iDisplayLength: 10,
	});
</script>
@endpush

