@extends('layout.adminMain')
@section("title","Announcements")
@section('content')
    <div class="row mt-30">
        <div class="col-md-4">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <h3 class="card-title">Announcements</h3>
                </div>
                <div class="card-body">
                    {{ Form::model($model,array('url'=>'/admin/announcements', 'method' => 'post', 'files' => true))}}
                    {{ Form::hidden('id',null) }}
                    {{ Form::hidden('old_image',$model['attachment']) }}
                     {{ Form::hidden('old_pdf',$model['attachment']) }}

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Title</label>
                                {{ Form::text('title',null,['class'=>'form-control required','placeholder'=>'Title','required']) }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Date</label>
                                {{ Form::text('date',null,['class'=>'form-control fc-datepicker required','placeholder'=>'Date','autocomplete'=>'off','required']) }}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Details</label>
                                {{ Form::textarea('description',null,['rows'=>'6','class'=>'form-control','placeholder'=>'Details']) }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Image</label>
                                {{ Form::file('new_image',['class'=>'form-control image_type']) }}
                                @if($model['attachment']!='')
                                    <a href="{{ uploads($model['attachment']) }}" target="_blank" class="btn btn-outline-info btn-sm mt-5">
                                        <i class="fa fa-eye"></i> View Image
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>PDF</label>
                                {{ Form::file('new_pdf',['class'=>'form-control doc_type pdf','accept'=>"application/pdf"]) }}
                                @if($model['pdf']!='')
                                    <a href="{{ uploads($model['pdf']) }}" target="_blank" class="btn btn-outline-info btn-sm mt-5  ">
                                        <i class="fa fa-eye"></i> View PDF
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>URL</label>
                                {{ Form::url('url',null,['class'=>'form-control','placeholder'=>'URL']) }}
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
                    <h3 class="card-title">Announcements</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table  id="current_affairs" class="table table-striped table-bordered w-100">
                            <thead class="bg-blue">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Details</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($table_list['data'] as $array)
                                <tr>
                                    <td>{{ (($table_list['current_page']-1)*$table_list['per_page'])+$loop->iteration }}</td>
                                    <td> {{ $array['title'] }}    </td>
                                    <td class="text-nowrap">{{ date('d-m-Y',strtotime($array['date'])) }}</td>
                                    <td data-container="body" data-toggle="tooltip" data-popover-color="default" data-placement="left"  data-original-title="{{ $array['description'] }}">{{ substr($array['description'],0,130) }}</td>
                                    <td class="text-nowrap">
                                        @if($array['attachment']!='' )
                                            <a target="_blank" href="{{uploads($array['attachment'])}}" class="table_icons" data-toggle="tooltip" data-original-title="Image"><i class="ti ti-eye" aria-hidden="true"></i></a>
                                        @endif
                                          @if($array['pdf']!='' )
                                            <a target="_blank" href="{{uploads($array['pdf'])}}" class="table_icons" data-toggle="tooltip" data-original-title="PDF"><i class="ti ti-eye" aria-hidden="true"></i></a>
                                        @endif
                                        <a href="{{ route('adminAnnouncements',['id'=>$array['id']])}}" class="table_icons" data-toggle="tooltip" data-original-title="Edit"><i class="ti ti-pencil" aria-hidden="true"></i></a>
                                        <a href="{{ route('dynamicDelete',['modal'=>'Announcement','id'=>$array['id'],'image'=>$array['attachment']]) }}" class="table_icons confirm-delete" data-toggle="tooltip" data-original-title="Delete" ><i class="ti ti-trash" aria-hidden="true"></i></a>
                                        @if($array['url']!='')
                                        <a href="{{ $array['url'] }}" target="_blank" class="table_icons" data-toggle="tooltip" data-original-title="URL"><i class="fa fa-eye"></i></a>
                                    @endif  
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
        </script>
    @endif
@endpush
