@extends('layout.adminMain')
@section('title','Banner Images')
@section('content')
    <div class="row mt-30">
        <div class="col-md-4">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <h3 class="card-title">Quiz Instruction</h3>
                </div>
                <div class="card-body">
                    {{ Form::model($model,array('url'=>'/admin/quizInstruction', 'method' => 'post', 'files' => true))}}
                    {{ Form::hidden('id',null,[]) }}

                    <div class="row">


                        <div class="col-lg-12">
                            <label>Type</label>
                            <div class="custom-controls-stacked mt-10">
                                <label class="custom-control custom-radio">
                                    {{ Form::radio('type', 'MCQ', true, array('class'=>'custom-control-input')) }}
                                    <span class="custom-control-label">MCQ</span>
                                </label>
                                <label class="custom-control custom-radio">
                                    {{ Form::radio('type', 'Special', false, array('class'=>'custom-control-input ')) }}
                                    <span class="custom-control-label">Test Series</span>
                                </label>
                                <label class="custom-control custom-radio">
                                    {{ Form::radio('type', 'Chapter', false, array('class'=>'custom-control-input ')) }}
                                    <span class="custom-control-label">Course Quiz</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Instruction</label>
                                {{ Form::textarea('instruction',null,['rows'=>5,'class'=>'form-control','id'=>'content_new','placeholder'=>'Instruction']) }}
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
                    <h3 class="card-title">Banner Images</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table  id="current_affairs" class="table table-striped table-bordered w-100">
                            <thead class="bg-blue">
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Instruction</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @php
                                $type=['MCQ'=>'MCQ','Special'=>'Test Series','Chapter'=>'Course Quiz']
                                @endphp
                            @foreach($table_list['data'] as $array)
                                <tr>
                                    <td>{{$loop->iteration }}</td>
                                    <td>{{$type[$array['type']]}}</td>
                                    <td>{!!$array['instruction']!!}</td>
                                    <td>
                                        <a href="{{url('admin/quizInstruction/'.$array['id'])}}" class="table_icons" data-toggle="tooltip" data-original-title="Edit" ><i class="ti ti-pencil" aria-hidden="true"></i></a>
                                        <a href="{{ route('dynamicDelete',['modal'=>'QuizInstruction','id'=>$array['id'],'image'=>$array['image']]) }}" class="table_icons confirm-delete" data-toggle="tooltip" data-original-title="Delete" ><i class="ti ti-trash" aria-hidden="true"></i></a>
                                        @if($array['url']!='')
                                            <a href="{{ $array['url'] }}" target="_blank" class="table_icons" data-toggle="tooltip" data-original-title="URL"><i class="fa fa-eye"></i></a>
                                        @endif
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


    <!--********************** Email Sent View Modal End *********************-->
@endsection
@push('includeJs')
   {{ Html::script('assets/plugins/ckeditor/ckeditor.js') }}
    @include('includes.CssJs.advanced_form')
    <script>

             var toolbarGp = [
        		{ name: 'basicstyles', groups: [ 'Bold', 'Italic', 'Strike', '-', 'RemoveFormat' ] },
        	
               	{ name: 'insert', groups: ['Table', 'HorizontalRule', 'SpecialChar' ] },
        		{ name: 'tools', groups: [ 'Maximize' ] },
        		{ name: 'paragraph', groups: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ] },
        		{ name: 'styles', groups: [ 'Styles', 'Format' ] }

        	];

            CKEDITOR.replace('content_new', {
                 toolbarGroups:toolbarGp,
                removePlugins: 'elementspath',
                resize_enabled: true,
                 allowedContent: true,
            });
    </script>
    {{ Html::script('assets/ascii2unicode/map_nudi_baraha.js') }}
    {{ Html::script('assets/ascii2unicode/helper.js') }}
    {{ Html::script('assets/ascii2unicode/a2u.js') }}
    <script type="text/javascript">
        $(document).ready(function() {
            converter_init();
        });
    </script>
@endpush

