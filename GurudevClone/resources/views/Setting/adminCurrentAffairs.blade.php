@extends('layout.adminMain')
@section('title', 'Current Affairs')
@section('content')
    <div class="row mt-30">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <h3 class="card-title">Current Affairs</h3>
                    <div class="card-options">
                        <a href="javascript:void(0)" id="convert-current-affairs" class="btn btn-danger mr-5">Convert to
                            Kannada</a>
                        <a href="{{ url('/admin/currentAffairs/list') }}" class="btn btn-primary">Current Affair List</a>
                    </div>
                </div>
                <div class="card-body">
                    {{ Form::model($model, ['url' => '/admin/currentAffairs', 'method' => 'post', 'files' => true]) }}
                    {{ Form::hidden('id', null) }}
                    {{ Form::hidden('image', null) }}
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Title</label>
                                {{ Form::text('title', null, ['class' => 'form-control required', 'id' => 'title', 'placeholder' => 'Title', 'required']) }}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Date</label>
                                {{ Form::text('date', null, ['class' => 'form-control fc-datepicker required', 'placeholder' => 'Date', 'autocomplete' => 'off', 'required']) }}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Image</label>

                                @if ($model['image'] != '')
                                    {{ Form::file('new_image', ['class' => 'form-control image_type required', 'accept' => 'image/*']) }}
                                    <a class="text-danger" href="{{ uploads($model['image']) }}" target="_blank">Uploaded</a>
                                @else
                                    {{ Form::file('new_image', ['class' => 'form-control image_type required', 'accept' => 'image/*', 'required']) }}
                                @endif
                                <span class="text-danger">Upload 700*300 resolution image</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Source</label>
                                {{ Form::text('source', null, ['class' => 'form-control ', 'id' => 'source', 'placeholder' => 'Source', 'autocomplete' => 'off']) }}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Tags <i class="text-danger icon-question" data-toggle="tooltip"
                                        title="For multiple values use comma(,) for separate"></i></label>
                                {{ Form::text('tags', null, ['class' => 'form-control ', 'id' => 'tags', 'placeholder' => 'Tags', 'autocomplete' => 'off']) }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Details</label>
                                {{ Form::textarea('description', null, ['rows' => '6', 'class' => 'form-control required', 'id' => 'content_new', 'placeholder' => 'Details', 'required']) }}
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
    </div>
@endsection
@push('includeJs')
    {{ Html::script('assets/plugins/ckeditor/ckeditor.js') }}
    @include('includes.CssJs.advanced_form')

    @if (!$model)
        <script>
            var date = new Date();
            var month = date.getMonth() + 1;
            var day = date.getDate();
            var today = (day < 10 ? '0' : '') + day + '-' + (month < 10 ? '0' : '') + month + '-' + date.getFullYear();
            $('.fc-datepicker').val(today)
        </script>
    @endif
    <script>
        var toolbarGp = [{
                name: 'basicstyles',
                groups: ['Bold', 'Italic', 'Strike', '-', 'RemoveFormat']
            },
            {
                name: 'editing',
                groups: ['Scayt']
            },
            {
                name: 'links',
                groups: ['Link', 'Unlink', 'Anchor']
            },
            {
                name: 'insert',
                groups: ['Table', 'HorizontalRule', 'SpecialChar']
            },
            {
                name: 'tools',
                groups: ['Maximize']
            },
            {
                name: 'paragraph',
                groups: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']
            },
            {
                name: 'styles',
                groups: ['Styles', 'Format']
            }

        ];

        var editor = CKEDITOR.replace('content_new', {
            toolbarGroups: toolbarGp,
            removePlugins: 'elementspath',
            resize_enabled: true,
            allowedContent: true,
        });
        editor.on('required', function(evt) {
            $('body').find('.cke_notification').remove();
            editor.showNotification('This field is required.', 'warning');
            evt.cancel();
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
