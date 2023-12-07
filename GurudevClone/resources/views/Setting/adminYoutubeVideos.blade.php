@extends('layout.adminMain')
@section("title","Youtube Videos")
@section('content')
    <div class="row mt-30">
        <div class="col-md-4">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <h3 class="card-title">Youtube Videos </h3>
                </div>
                <div class="card-body">
                    {{ Form::model($model,array('url'=>'/admin/youtubeVideos', 'method' => 'post', 'files' => true))}}
                    {{ Form::hidden('id',null) }}
                    {{ Form::hidden('link',null,["class"=>"trimmedLink"]) }}

                    {{-- {{ Form::hidden('old_tumnnail',$model['thumbnail']) }} --}}


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
                                <label>Link <span class="text-danger">Paste Video Link</span></label>
                                {{ Form::text('untrim_link',null,['class'=>'form-control required videoLink','placeholder'=>'Video Link','required']) }}

                            </div>
                        </div>
                        {{-- <div class="col-md-12">
                            <div class="form-group">
                                <label>Thumbnail</label>
                                {{ Form::file('new_thumbnail',['class'=>'form-control','accept'=>"image/png, image/gif, image/jpeg"]) }}
                                @if($model['thumbnail']!='')<span class='text-danger'>Thumbnail Uploaded <br/></span>@endif
                                <span class="text-danger">Upload  695*536 resolution thumbnail</span> <br/>
                            </div>

                        </div> --}}

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
                    <h3 class="card-title">Youtube Video List</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table  id="current_affairs" class="table table-striped table-bordered w-100">
                            <thead class="bg-blue">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Video</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($table_list as $array)
                                <tr>
                                    <td>{{ (($table_list['current_page']-1)*$table_list['per_page'])+$loop->iteration }}</td>
                                    <td> {{ $array['title'] }}    </td>
                                    <td class="text-nowrap">{{ date('d-m-Y',strtotime($array['date'])) }}</td>
                                     {{-- <td> @if($array['thumbnail']!='' && file_exists(public_path($array['attachment'])))
                                            <a target="_blank" href="{{uploads($array['thumbnail'])}}" class="table_icons" data-toggle="tooltip" data-original-title="Attachment">
                                                <img class="avatar bradius mr-2" src="{{uploads($array['thumbnail'])}}" onerror='this.src="{{uploads('/Uploads/default.jpg')}}"'\>
                                            </a>
                                        @endif   </td> --}}
                                    <td>  <a target="_blank" href="https://www.youtube.com/watch?v={{$array['link']}}" class="table_icons" data-toggle="tooltip" data-original-title="Attachment"><i class="ti ti-eye" aria-hidden="true"></i> Watch</a></td>
                                    <td class="text-nowrap">

                                                                                <a href="{{ route('adminYoutubeVideos',['id'=>$array['id']])}}" class="table_icons" data-toggle="tooltip" data-original-title="Edit"><i class="ti ti-pencil" aria-hidden="true"></i></a>
                                        <a href="{{ route('dynamicDelete',['modal'=>'YoutubeVideo','id'=>$array['id']]) }}" class="table_icons confirm-delete" data-toggle="tooltip" data-original-title="Delete" ><i class="ti ti-trash" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            @if ($table_list->total() == 0)
                            <tr>
                               <th class='text-center' colspan="5">No Videos Found</th>
                            </tr>
                            @endif
                            </tbody>
                        </table>
                        <div class="col-lg-12">
                            {{-- Pagination --}}
                            <div class="d-flex justify-content-center">

                                {!! $table_list->links() !!}
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
    <script>
    @if($model['id']=='')

            var date = new Date();
            var month = date.getMonth()+1;
            var day = date.getDate();
            var today = (day<10 ? '0' : '') + day+'-'+(month<10 ? '0' : '') + month+'-'+date.getFullYear();
            $('.fc-datepicker').val(today)

    @else
    let link="{{$model['link']}}"
    $('.videoLink').val('https://www.youtube.com/watch?v='+link)

    @endif

    $('.videoLink').bind('keypress', function(e) {
        e.preventDefault();
    });
    $('.videoLink').bind('paste', function(e) {
        var pastedData = e.originalEvent.clipboardData.getData('text');
           try{
                var video_id = pastedData.match(/v=(.{11})/)[1]
                $('.trimmedLink').val(video_id)
           }catch(error){
                alert('invalid video link')
                e.preventDefault();
                return;
            }
    });
</script>
@endpush
