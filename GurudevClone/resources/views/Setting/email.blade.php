@extends('layout.adminMain')
@section("title","Email")
@section('content')
    <div class="row mt-30">
        <div class="col-md-4">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <h3 class="card-title">Compose Email</h3>
                </div>
                <div class="card-body">
                    {{ Form::model($model,array('url'=>'/admin/email', 'method' => 'post', 'files' => true))}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>To</label>
                                {{ Form::select('user_id[]',$users,null,['class'=>'form-control select2-show-search required','required','multiple']) }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Subject</label>
                                {{ Form::text('subject',null,['class'=>'form-control required','placeholder'=>'Subject','autocomplete'=>'off','required']) }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Details</label>
                                {{ Form::textarea('details',null,['rows'=>'6','class'=>'form-control required','placeholder'=>'Details','required']) }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Attachment</label>
                                {{ Form::file('attachment',['class'=>'form-control stud_doc']) }}
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
                    <h3 class="card-title">Sent Email</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table  id="current_affairs" class="table table-striped table-bordered w-100">
                            <thead class="bg-blue">
                            <tr>
                                <th>#</th>
                                <th>Subject</th>
                                <th>Details</th>
                                <th>Attachment</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($table_list['data'] as $array)
                                <tr>
                                    <td>{{ (($table_list['current_page']-1)*$table_list['per_page'])+$loop->iteration }}</td>
                                    <td> {{ $array['subject'] }}    </td>
                                    <td> {{ $array['details'] }}    </td>
                                    <td>
                                        @if($array['attachment']!='')
                                            <a target="_blank" href="{{uploads($array['attachment'])}}" class="table_icons" data-toggle="tooltip" data-original-title="Attachment"><i class="ti ti-eye" aria-hidden="true"></i></a>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" data-emails="{{$array['email']}}" class="table_icons view_emails" data-toggle="tooltip" data-original-title="View Email"><i class="fa fa-envelope-open" aria-hidden="true" ></i></a>
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
