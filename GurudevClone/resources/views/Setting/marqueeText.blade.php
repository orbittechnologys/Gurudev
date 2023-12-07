@extends('layout.adminMain')
@section('title','Marquee Text')
@section('content')
    <div class="row mt-30">
        <div class="col-md-4">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <h3 class="card-title">Marquee Text</h3>
                </div>
                <div class="card-body">
                    {{ Form::model($model,array('url'=>'/admin/marqueeText', 'method' => 'post', 'files' => true))}}
                    {{ Form::hidden('id',null,[]) }}
                    <div class="row"> 
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Marquee Text</label>
                                    {{ Form::text('image',null,['class'=>'form-control required','placeholder'=>'Marquee Text','required']) }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>URL</label>
                                {{ Form::url('url',null,['class'=>'form-control required','placeholder'=>'URL','required']) }}
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
                    <h3 class="card-title">Marquee Text</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table  id="current_affairs" class="table table-striped table-bordered w-100">
                            <thead class="bg-blue">
                            <tr>
                                <th>#</th>
                                <th>Marquee Text</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($table_list['data'] as $array)
                                <tr>
                                    <td>{{ (($table_list['current_page']-1)*$table_list['per_page'])+$loop->iteration }}</td>
                                    <td>{{$array['image']}}</td>
                                    {{-- <td>
                                        @if($array['image']!='' && file_exists(public_path($array['image'])))
                                            <a target="_blank" href="{{uploads($array['image'])}}" class="table_icons">
                                                <img src="{{uploads($array['image'])}}" class="img-avatar" />
                                            </a>
                                        @endif
                                    </td> --}}
                                    <td>
                                        <a href="{{url('admin/marqueeText/'.$array['id'])}}" class="table_icons" data-toggle="tooltip" data-original-title="Edit" ><i class="ti ti-pencil" aria-hidden="true"></i></a>
                                        <a href="{{ route('dynamicDelete',['modal'=>'BannerImages','id'=>$array['id'],'image'=>$array['image']]) }}" class="table_icons confirm-delete" data-toggle="tooltip" data-original-title="Delete" ><i class="ti ti-trash" aria-hidden="true"></i></a>
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

    <!--********************** Email Sent View Modal Start *********************-->
    <div class="modal" id="emailView">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-5">
                    <h4 class="modal-title">Sent To</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive" id="email_table">

                            </div>
                        </div>
                    </div>
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
    @if(!$model)
        <script>
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
        </script>
    @endif
@endpush
