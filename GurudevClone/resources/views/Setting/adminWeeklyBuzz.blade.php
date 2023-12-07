@extends('layout.adminMain')
@section("title","Weekly Buzz")
@section('content')
    <div class="row mt-30">
        <div class="col-md-4">

            <div class="card overflow-hidden">
                <div class="card-header">
                    <h3 class="card-title">E Magazine</h3>

                <div class="card-options">
                    <div class="pull-right">
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#examTypeModal"
                            class="btn btn-info btn-icon text-white mr-2">
                            <span><i class="fa fa-plus"></i></span> Add Folder
                        </a>
                    </div>
                </div>
            </div>
                <div class="card-body">
                    {{ Form::model($model,array('url'=>'/admin/weeklyBuzz', 'method' => 'post', 'files' => true))}}
                    {{ Form::hidden('id',null) }}
                    {{ Form::hidden('old_image',$model['attachment']) }}
                    {{ Form::hidden('old_tumnnail',$model['thumbnail']) }}
                        <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Title</label>
                                {{ Form::text('title',null,['class'=>'form-control required','placeholder'=>'Title','required']) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Select Folder</label>
                                {{ Form::select('weekly_buzz_folder_id',$folder_list,null,['class'=>'select2-show-search required','required',"placeholder"=>"Select Folder"])}}

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date</label>
                                {{ Form::text('date',null,['class'=>'form-control fc-datepicker required','placeholder'=>'Date','autocomplete'=>'off','required']) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Attachment</label>
                               
                                @if($model['attachment']!='')
                                {{ Form::file('new_image',['class'=>'form-control doc_type ','accept'=>"application/pdf"]) }}
                                <span class='text-danger'>File Uploaded</span>
                                @else
                                {{ Form::file('new_image',['class'=>'form-control doc_type required','required','accept'=>"application/pdf"]) }}
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Thumbnail</label>
                               
                                @if($model['thumbnail']!='')
                                {{ Form::file('new_thumbnail',['class'=>'form-control image_type','accept'=>"image/png, image/gif, image/jpeg"]) }}
                                <span class='text-danger'>Thumbnail Uploaded <br/></span>
                                @else
                                {{ Form::file('new_thumbnail',['class'=>'form-control image_type required','required','accept'=>"image/png, image/gif, image/jpeg"]) }}
                                @endif
                                <span class="text-danger">Upload  695*536 resolution thumbnail</span> <br/>
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
                    <h3 class="card-title">E Magazine</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table  id="current_affairs" class="table table-striped table-bordered w-100">
                            <thead class="bg-blue">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Folder</th>
                                <th>Date</th>
                                <th>Thumbnail</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($table_list['data'] as $array)
                                <tr>
                                    <td>{{ (($table_list['current_page']-1)*$table_list['per_page'])+$loop->iteration }}</td>
                                    <td> {{ $array['title'] }}    </td>
                                    <td> {{ $array['weekly_buzz_folder']['folder_name'] }}    </td>
                                    <td class="text-nowrap">{{ date('d-m-Y',strtotime($array['date'])) }}</td>
                                     <td> @if($array['thumbnail']!='')
                                            <a target="_blank" href="{{uploads($array['thumbnail'])}}" class="table_icons" data-toggle="tooltip" data-original-title="Attachment">
                                                <img class="avatar bradius mr-2" src="{{uploads($array['thumbnail'])}}" onerror='this.src="{{uploads("Uploads/default.jpg")}}"'>
                                            </a>
                                        @endif   </td>
                                    <td class="text-nowrap">
                                        @if($array['attachment']!='' )
                                            <a target="_blank" href="{{uploads($array['attachment'])}}" class="table_icons" data-toggle="tooltip" data-original-title="Attachment"><i class="ti ti-eye" aria-hidden="true"></i></a>
                                        @endif
                                        <a href="{{ route('adminWeeklyBuzz',['id'=>$array['id']])}}" class="table_icons" data-toggle="tooltip" data-original-title="Edit"><i class="ti ti-pencil" aria-hidden="true"></i></a>
                                        <a href="{{ route('dynamicDelete',['modal'=>'WeeklyBuzz','id'=>$array['id'],'image'=>$array['attachment']]) }}" class="table_icons confirm-delete" data-toggle="tooltip" data-original-title="Delete" ><i class="ti ti-trash" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            @if(sizeof($table_list['data'])==0)
                            <tr>
                               <th class='text-center' colspan="4">No E Magazine Found</th>
                            </tr>
                            @endif
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

    <div id="examTypeModal" class="modal fade">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content ">
                <div class="modal-header pd-x-20">
                    <h6 class="modal-title">Folder</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pd-20" id="absentees">
                    {{ Form::model($model,array('url'=>'/admin/weeklyBuzzFolder', 'method' => 'post'))}}
                    {{ Form::hidden('id', null, ['id' => 'new_exam_type_id']) }}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="input-group mt-10">
                                {{ Form::text('folder_name',null,['class'=>'form-control new_exam_type required','placeholder'=>'Folder','required']) }}
                                <span class="input-group-append">
                                    <button type="submit" class="btn btn-primary"
                                        type="button">Save</button>
                                </span>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table
                                    class="dataTable-1 table table-hover text-nowrap table-striped table-bordered text-nowrap w-100">
                                    <thead class="bg-blue">
                                        <tr class="hidden-row">
                                            <td>#</td>
                                            <td>Folder Name</td>
                                            <td>Action</td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($folder_list as $key=>$item)


                                        <tr>
                                            <td >{{ $loop->iteration }}</td>
                                            <td>{{ $item }} </td>
                                            <td>
                                                <a href="javascript:void(0)" class="table_icons" data-toggle="tooltip"
                                                    data-original-title="Edit"
                                                    onclick="editExamType('{{ $key }}','{{ $item }}')"><i
                                                        class="ti ti-pencil text-primary" aria-hidden="true"></i></a>

                                                <a href="{{ route('dynamicDelete', ['modal' => 'WeeklyBuzzFolder', 'id' => $key]) }}"
                                                    class="table_icons confirm-delete" data-toggle="tooltip"
                                                    data-original-title="Delete"><i class="ti ti-trash text-danger"
                                                        aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                       @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
                <!-- modal-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div><!-- MODAL DIALOG -->
    </div>
@endsection

@push('includeJs')
    @include('includes.CssJs.advanced_form')
    @include('includes.CssJs.dataTable')
    @if(!$model)
        <script>
            var date = new Date();
            var month = date.getMonth()+1;
            var day = date.getDate();
            var today = (day<10 ? '0' : '') + day+'-'+(month<10 ? '0' : '') + month+'-'+date.getFullYear();
            $('.fc-datepicker').val(today)

            function editExamType(id, type, examType) {
            $('.new_exam_type').val(type);
            $('#new_exam_type_id').val(id);



        }
        </script>
    @endif
@endpush
