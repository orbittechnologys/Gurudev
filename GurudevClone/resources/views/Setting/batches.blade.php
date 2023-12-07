@extends('layout.adminMain')
@section("title","Batch")
@section('content')
    <div class="row mt-30">
        <div class="col-md-4">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <h3 class="card-title">Batches</h3>
                </div>
                <div class="card-body">
                    {{ Form::model($model,array('url'=>'/admin/batches', 'method' => 'post'))}}
                    {{ Form::hidden('id',null,[]) }}
                    {{ Form::hidden('user_id',null,['class'=>'_userId']) }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Batch</label>
                                {{ Form::text('batch',null,['class'=>'form-control required','placeholder'=>'Batch','required']) }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Course </label>
                                {{ Form::select('course_id[]',$course,null,['class'=>'form-control select2 course required','multiple','required']) }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Users</label>
                                {{ Form::select('user_id[]',$users,null,['class'=>'form-control select2 userId required','multiple','required']) }}
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
                    <h3 class="card-title">Batches</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table  id="current_affairs" class="table table-striped table-bordered w-100">
                            <thead class="bg-blue">
                            <tr>
                                <th>#</th>
                                <th>Batch</th>
                                <th>Course</th>
                                <th>Total Users</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($table_list['data'] as $array)
                                <tr>
                                    <td>{{ (($table_list['current_page']-1)*$table_list['per_page'])+$loop->iteration }}</td>
                                    <td>{{$array['batch']}}</td>
                                    <td>
                                        @php($selectedCourses=explode(',',$array['course_id']))
                                        @foreach ($selectedCourses as $item)
                                            <p class="m-0">{{$course[$item]}}</p>
                                        @endforeach
                                    </td>
                                    <td>
                                        @php($selectedUsers=explode(',',$array['user_id']))

                                        <a href="javascript:void(0)" class="btn btn-sm btn-outline-primary view_members" data-id="{{$array['id']}}"><i class="fa fa-eye"></i> {{sizeof($selectedUsers)}} </a>
                                    </td>
                                    <td>
                                        <a href="{{url('admin/batches/'.$array['id'])}}" class="table_icons" data-toggle="tooltip" data-original-title="Edit" ><i class="ti ti-pencil" aria-hidden="true"></i></a>
                                        <a href="{{ route('dynamicDelete',['modal'=>'Batch','id'=>$array['id']]) }}" class="table_icons confirm-delete" data-toggle="tooltip" data-original-title="Delete" ><i class="ti ti-trash" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row mb-30">
                        <div class="col-lg-12">
                            <div class="mb-5">
                                <ul class="pagination float-right">
                                    <li class="page-item page-prev {{ ($table_list['current_page']==1) ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $table_list['prev_page_url'] }}" tabindex="-1">Previous</a>
                                    </li>

                                    @for($i=1;$i<=$table_list['last_page'];$i++)

                                        @if($table_list['current_page']<=4)
                                            <li class="page-item {{ ($i==$table_list['current_page']) ? 'active' : '' }}"><a class="page-link" href="{{ $table_list['path'].'?page='.$i }}">{{ $i }}</a></li>
                                        @endif


                                        @if($i>=5)
                                            @if($table_list['current_page']>=5)
                                                <li class="page-item {{ (1==$table_list['current_page']) ? 'active' : '' }}"><a class="page-link" href="{{ $table_list['path'].'?page=1' }}">{{ 1 }}</a></li>
                                                <li class="page-item"><a class="page-link" style="cursor: default;">...</a></li>
                                                <li class="page-item {{ ($table_list['current_page']-1==$table_list['current_page']) ? 'active' : '' }}"><a class="page-link" href="{{ $table_list['path'].'?page='.($table_list['current_page']-1) }}">{{ $table_list['current_page']-1 }}</a></li>
                                                <li class="page-item {{ ($table_list['current_page']==$table_list['current_page']) ? 'active' : '' }}"><a class="page-link" href="{{ $table_list['path'].'?page='.$table_list['current_page'] }}">{{ $table_list['current_page'] }}</a></li>
                                                @if(($table_list['current_page']+1)<$table_list['last_page'])
                                                    <li class="page-item {{ ($table_list['current_page']+1==$table_list['current_page']) ? 'active' : '' }}"><a class="page-link" href="{{ $table_list['path'].'?page='.($table_list['current_page']+1) }}">{{ $table_list['current_page']+1 }}</a></li>
                                                @endif
                                            @endif

                                            @if($table_list['current_page']!=$table_list['last_page'] && ($table_list['current_page']+1)!=$table_list['last_page'])
                                                <li class="page-item"><a class="page-link" style="cursor: default;">...</a></li>
                                                <li class="page-item {{ ($table_list['last_page']==$table_list['current_page']) ? 'active' : '' }}"><a class="page-link" href="{{ $table_list['last_page_url'] }}">{{ $table_list['last_page'] }}</a></li>
                                            @endif
                                            @break
                                        @endif

                                    @endfor

                                    <li class="page-item page-next {{ ($table_list['current_page']==$table_list['last_page']) ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $table_list['next_page_url'] }}">Next</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--********************** Email Sent View Modal Start *********************-->
    <div class="modal" id="viewMembersModal">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-5">
                    <h4 class="modal-title">Batch Users</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--********************** Email Sent View Modal End *********************-->
@endsection

@push('includeJs')
    @include('includes.CssJs.advanced_form')
    @include('includes.CssJs.dataTable')

    <script>
        $('.course').trigger('change');
            $('.course').on('change',function(){
                if($(this).val()!=''){
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        type: 'POST',
                        data: { 'course': $(this).val() },
                        url:"{{ url('/admin/getUsersOnCourse') }}",
                        dataType: 'json',
                        success: function (data) {
                            var alreadySelected=$('.userId').val();

                            $('.userId').find('option').remove();
                            $.each(data, function (index, value) {
                                $('.userId').append(new Option(value,index));
                            });

                            $('.userId').trigger('change');

                            if($('._userId').val()!=''){
                                var alreadySelected=$('._userId').val();
                                alreadySelected=alreadySelected.split(',');
                                $('._userId').val('');
                            }
                            $('.userId').val(alreadySelected);
                        },
                        error: function (data) { }
                    });
                } else{
                    $('.userId').find('option').remove();
                }
            });
            $('body').find('.course').trigger('change');

           $('.view_emails').on('click',function(){
               var emails=$(this).attr('data-emails');
               emails= emails.split(',');
               var tr='<thead class="bg-blue"><tr><td>#</td><td>Email</td></tr></thead>';
               var j=1;
               for(i=0;i<emails.length;i++){
                   tr+=`<tr><td>`+j+`</td><td>`+emails[i]+`</td></tr>`;
                   j++;
               }
               $('#email_table').empty();
               $('#email_table').html(`<table class="table table-bordered table-striped">`+tr+`</table>`);
               $('#emailView').modal('show');
           });

           $('.view_members').on('click',function(){
               id=$(this).attr('data-id');
               $('#viewMembersModal').find('.modal-body').load('{{url('admin/batchMembersLoad')}}/'+id,function(){
                   $('#viewMembersModal').modal('show');
               });
           });
        </script>
@endpush
