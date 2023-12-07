@extends('layout.adminMain')
@section('title', 'Question Bank')
@push('includeCss')
    <style>
        .question div,
        h1,
        h2,
        h3,
        h4,
        h5 {
            display: inline;
        }


        hr.question-details {
            border-top: 1px dotted red;
            width: 100%;
            margin: 10px 0;
            padding: 0;
        }

        .richText .richText-editor {
            height: 130px !important;
        }

        .richText .richText-toolbar ul li a .richText-dropdown-outer ul {
            overflow: scroll;
            height: 300px;
        }

        .richText .richText-toolbar ul li a .richText-dropdown-outer ul.richText-dropdown {
            list-style: none;
            z-index: 5;
        }

        .rich-text-editor-lable {
            font-weight: 500 !important;
            text-align: center;
            width: inherit;
            font-size: 14px;
        }

        .header .form-inline .form-control {
            border: 1px solid #e3e3f7;
            width: 500px;
            background: #e5e6fb !important;
            color: #222222 !important;
        }

        @media screen and (max-width: 940px) {

            .header .form-inline .form-control {
                width: 320px;
            }

        }

        .negetiveMarking {
            display: flex;
        }

        .negetiveMarking input {
            width: 100px;
            margin-left: 20px;
            margin-top: -10px;
        }

        .to-kannada {
            position: absolute;
            right: 16px;
            top: 10px;
        }
    </style>
@include('includes.CssJs.advanced_form')
@endpush

@section('content')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-home mr-1"></i>Questions Bank</a></li>

        </ol>
        <div class="ml-auto">
            {{ Form::text('global_search', null, ['class' => 'form-control global_search', 'placeholder' => 'Enter Question Or Tags to filter']) }}
        </div>
    </div>
    <div class="my-loader">
        <div class="lds-hourglass myloader-image"></div>
    </div>
    <div class="content-body fadeOutRight" id="questions_load">
        <div class="col-md-12 col-lg-12 mt-30">
            <div class="card auth-card bg-transparent shadow-none rounded-0 mt-50 w-100">
                <div class="card-content">
                    <div class="card-body text-center">
                        <div class="mb-30 mt-20">
                            <img src="{{ URL::asset('user/images/404.jpg') }}"
                                class="img-fluid align-self-center not-found-img" alt="branding logo">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a class="fixed-bottom-right" href="{{ url('/admin/questions/add') }}">
        <i class="fa fa-plus fa-2x"></i>
    </a>

    <!-- LARGE MODAL For Quiz Questions Edit -->
    <div id="quiz_question_modal" class="modal fade">
        <div class="modal-dialog modal-lg" style="max-width: 95%" role="document">
            <div class="modal-content ">
                <div class="modal-header pd-x-20">
                    <h6 class="modal-title">Edit Question</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{ Form::open(['url' => '/admin/questions/add', 'method' => 'POST', 'class' => 'validate-form', 'id' => '']) }}
                {{ Form::hidden('id', '', ['id' => 'questionId']) }}

                <div class="modal-body pd-20">
                    <div class="row mt-20">
                        <div class="col-lg-3">
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">

                                {{ Form::text('tags', null, ['class' => 'form-control', 'id' => 'tags', 'data-toggle' => 'tooltip', 'data-html' => 'true', 'data-container' => 'body', 'data-original-title' => "<span class='text-nowrap'>Enter tags these Question's belongs to</span><br/> use (,) for Multiple Tags", 'required', 'placeholder' => 'EX: IAS,IPS,Current Affairs']) }}
                            </div>
                        </div>
                    </div>
                    <div class="row mt-30">

                        <div class="col-md-6 col-12">

                            <div class="row neg-m-t-30">
                                <div class="col-lg-12 ">
                                    <label class="rich-text-editor-lable">Question</label>
                                    <div class="form-group">
                                        <button type="button" class="to-kannada btn btn-sm btn-success mt-30" description-id="qu_description" editor-id="questionContent">To Kannada</button>
                                    <textarea name="question" class="questionContent" id="questionContent" placeholder="Question"></textarea>
                                    </div>
                                </div>

                            </div>
                            <br />
                            <div class="row">
                                <div class="col-lg-12 m-t-20 ">
                                    <label class="rich-text-editor-lable">Description</label>
                                    <textarea name="description" id="qu_description" class="qu_description width-full" rows="6"></textarea>
                                </div>
                            </div>


                        </div>
                        <div class=" col-md-6 col-12">
                            <div class="row mt-sm-30">
                                <div class="col-lg-3 ml-15">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Question Marks </label>
                                        <input name="marks" value="1" class="form-control required" id="marks"
                                            placeholder="Marks" required>
                                    </div>
                                </div>
                                <div class="col-lg-6 ml-15">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Is Question have Negative Marks ?</label>
                                        <div class="material-switch mt-10 pull-right">
                                            <input name="is_negative" value="1" id="1negative_marking"
                                                class="negative_marking" type="checkbox" />
                                            <label for="1negative_marking" class="label-danger"></label>
                                        </div>
                                        <input name="negative_marking" class="form-control negative_marking_input" value="0"
                                            placeholder="Negative Marks" id="1negative_marking_input" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-sm-30">
                                <div class="col-1 max-width-2 pt-10">
                                    <h4>1</h4>
                                </div>
                                <div class="col-md-10 col-8">
                                    <div class="form-group">
                                        <button type="button" class="to-kannada btn btn-sm btn-success" editor-id="answer1">To Kannada</button>
                                        {{-- {{ Form::text('answer1','',['class'=>'form-control form-input','placeholder'=>'answer1','id'=>'answer1','required']) }} --}}
                                        <textarea name="answer1" id='answer1' placeholder='answer1' required></textarea>
                                    </div>
                                </div>

                                <div class="col-md-1 col-2">
                                    <div class="material-switch mt-10 pull-right">
                                        <input id="correct1" name="correct" value="1" class="1correct"
                                            onclick="selectAnswer(this,'1correct')" type="checkbox" />
                                        <label for="correct1" class="label-primary"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row  ">
                                <div class="col-1 max-width-2 pt-10">
                                    <h4>2</h4>
                                </div>
                                <div class="col-md-10 col-8">
                                    <div class="form-group">
                                        <button type="button" class="to-kannada btn btn-sm btn-success" editor-id="answer2">To Kannada</button>
                                        <textarea name="answer2" id='answer2' placeholder='answer2' required></textarea>
                                        {{-- {{ Form::text('answer2','',['class'=>'form-control form-input','placeholder'=>'answer2','id'=>'answer2','required']) }} --}}
                                    </div>
                                </div>
                                <div class="col-md-1 col-2">
                                    <div class="material-switch mt-10 pull-right">
                                        <input id="correct2" name="correct" value="2" class="1correct"
                                            onclick="selectAnswer(this,'1correct')" type="checkbox" />
                                        <label for="correct2" class="label-primary"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row  ">
                                <div class="col-1 max-width-2 pt-10">
                                    <h4>3</h4>
                                </div>
                                <div class="col-md-10 col-8">
                                    <div class="form-group">
                                        <button type="button" class="to-kannada btn btn-sm btn-success" editor-id="answer3">To Kannada</button>
                                        <textarea name="answer3" id='answer3' placeholder='answer3'></textarea>
                                        {{-- {{ Form::text('answer3','',['class'=>'form-control form-input',  'placeholder'=>'answer3','id'=>'answer3']) }} --}}
                                    </div>
                                </div>
                                <div class="col-md-1 col-2">
                                    <div class="material-switch mt-10 pull-right">
                                        <input id="correct3" name="correct" value="3" class="1correct"
                                            onclick="selectAnswer(this,'1correct')" type="checkbox" />
                                        <label for="correct3" class="label-primary"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row  ">
                                <div class="col-1 max-width-2 pt-10">
                                    <h4>4</h4>
                                </div>
                                <div class="col-md-10 col-8">
                                    <div class="form-group">
                                        <button type="button" class="to-kannada btn btn-sm btn-success" editor-id="answer4">To Kannada</button>
                                        {{-- {{ Form::text('answer4','',['class'=>'form-control form-input','placeholder'=>'answer4','id'=>'answer4']) }} --}}
                                        <textarea name="answer4" id='answer4' placeholder='answer4'></textarea>
                                    </div>
                                </div>
                                <div class="col-md-1 col-2">
                                    <div class="material-switch mt-10 pull-right">
                                        <input id="correct4" name="correct" value="4" class="1correct"
                                            onclick="selectAnswer(this,'1correct')" type="checkbox" />
                                        <label for="correct4" class="label-primary"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row  ">
                                <div class="col-1 max-width-2 pt-10">
                                    <h4>5</h4>
                                </div>
                                <div class="col-md-10 col-8">
                                    <div class="form-group">
                                        <button type="button" class="to-kannada btn btn-sm btn-success" editor-id="answer5">To Kannada</button>
                                        {{-- {{ Form::text('answer5','',['class'=>'form-control form-input','placeholder'=>'answer5','id'=>'answer5']) }} --}}
                                        <textarea name="answer5" id='answer5' placeholder='answer5'></textarea>
                                    </div>
                                </div>
                                <div class="col-md-1 col-2">
                                    <div class="material-switch mt-10 pull-right">
                                        <input id="correct5" name="correct" value="5" class="1correct"
                                            onclick="selectAnswer(this,'1correct')" type="checkbox" />
                                        <label for="correct5" class="label-primary"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-1 max-width-2 pt-10">
                                    <h4>6</h4>
                                </div>
                                <div class="col-md-10 col-8">
                                    <div class="form-group">
                                        <button type="button" class="to-kannada btn btn-sm btn-success" editor-id="answer6">To Kannada</button>
                                        {{-- {{ Form::text('answer6','',['class'=>'form-control form-input','placeholder'=>'answer6','id'=>'answer6']) }} --}}
                                        <textarea name="answer6" id='answer6' placeholder='answer6'></textarea>
                                    </div>
                                </div>
                                <div class="col-md-1 col-2">
                                    <div class="material-switch mt-10 pull-right">
                                        <input id="correct6" name="correct" value="6" class="1correct"
                                            onclick="selectAnswer(this,'1correct')" type="checkbox" />
                                        <label for="correct6" class="label-primary"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
@push('includeJs')
    {{ Html::script('js/jquery-slimscroll/jquery.slimscroll.min.js') }}
    {{ Html::script('assets/plugins/ckeditor/ckeditor.js') }}

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
            }

        ];
        $('#questions_load').load('{{ url('admin/questions/list/all') }}');
        var url = '{{ url('admin/questions/list/') }}'

        function myPagination(page, type) {
            if (type) {
                split_str = page.split('=');
                page = split_str[1];
            }
            search_string = $('.global_search').val();
            if (search_string === '') search_string = 'all'
            $('#questions_load').load(url + '/' + encodeURIComponent(search_string) + '?page=' + page);
        }
        $('.global_search').on('input', function() {
            search_string = $(this).val();
            if (search_string.length > 0) {
                $('#questions_load').load(url + '/' + encodeURIComponent(search_string));
            } else $('#questions_load').load(url + '/all');
        })



        $('#question_search').click(function() {
            $('#nav-search-bar').css('display', 'block');
            $('.header-search').focus();
            //console.log($(window).width());
            if ($(window).width() <= 767) {
                // $('.search-icon').click();
                $('.navsearch').click();
                // alert("da")
            }
        });

        function selectAnswer(curr, chkClass) {
            chkClass = $(curr).attr('class')
            $("." + chkClass).prop("checked", false);
            $(curr).prop("checked", true);
        }

        function getQuestion(id, loop) {

            $.ajax({
                type: "POST",
                url: '{{ url('/admin/questions/get') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                cache: false,
                success: function(data) {

                    for (var i = 1; i <= 6; i++) {
                        var optionid = 'answer' + i;

                        //$('#'+optionid).richText(editorConfig);

                        CKEDITOR.instances[optionid].setData(data['answer' + i]);
                        $('#answer' + i).val(data['answer' + i]);
                        if ('answer' + i == data['correct_answer'])
                            $('#correct' + i).prop('checked', true);
                        else
                            $('#correct' + i).prop('checked', false);
                    }

                    CKEDITOR.instances['questionContent'].setData(data['question']);
                    $('#tags').val(data['tags']);
                    $('.qu_description').val(data['description']);
                    $('#marks').val(data['marks']);

                    if (parseFloat(data['negative_marking']) == 0) {
                        $('.negative_marking').attr('checked', false);
                        $("#1negative_marking_input").val(0)
                        $("#1negative_marking_input").attr("readonly", true);
                    } else {
                        $('.negative_marking').attr('checked', true);
                        $("#1negative_marking_input").val(parseFloat(data['negative_marking']))
                        $("#1negative_marking_input").attr("readonly", false);
                    }
                    $('#questionId').val(data['id']);

                    $('#quiz_question_modal').modal('show');
                }
            });
        }

        $('.negative_marking').on('click', function() {

            if ($(this).is(':checked')) {
                $("#1negative_marking_input").val(1)
                $("#1negative_marking_input").attr("readonly", false);
                return

            }
            $("#1negative_marking_input").attr("readonly", true);
            $("#1negative_marking_input").val(0)

        });
        CKEDITOR.replace('questionContent', {
            toolbarGroups: toolbarGp,
            removePlugins: 'elementspath',
            resize_enabled: true,
            allowedContent: true,
            entities: false
        });
        for (var i = 1; i <= 6; i++) {
            var id = 'answer' + i;



            CKEDITOR.replace(id, {
                toolbarGroups: toolbarGp,
                height: '80px',
                removePlugins: 'elementspath',
                resize_enabled: false,
                allowedContent: true,
            });
        }
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
