@extends('layout.adminMain')
@section('title', 'Question Bank')
@push('includeJs')
    @include('includes.CssJs.advanced_form')
@endpush
@section('content')
    <style>
        .richText .richText-editor {
            height: 267px !important;
        }

        .tooltip-inner {
            max-width: 300px !important;
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
            font-weight: 500;
            text-align: center;
            width: inherit;
            font-size: 14px;
        }

        .font-size-16 {
            font-size: 16px;
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
    <div class="row mt-30">
        <div class="col-md-12">
            {{ Form::open(['url' => '/admin/questions/add', 'method' => 'POST', 'class' => 'validate-form', 'id' => 'questionAddForm']) }}
            {{ Form::hidden('total_questions', 01, ['id' => 'total_questions']) }}

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Add Questions</div>
                    <div class="card-options">
                        <div class="clearfix pull-right d-flex">
                            <div class="float-right">
                                {{ Form::submit('Save', ['class' => 'btn btn-info wrap ml-10 questions_submit']) }}</div>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row mt-20">
                        <div class="col-lg-3">
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">

                                {{ Form::text('tags', null, ['class' => 'form-control', 'data-toggle' => 'tooltip', 'data-html' => 'true', 'data-container' => 'body', 'data-original-title' => "<span class='text-nowrap'>Enter tags these Question's belongs to</span><br/> use (,) for Multiple Tags", 'required', 'placeholder' => 'EX: IAS,IPS,Current Affairs']) }}
                            </div>
                        </div>
                    </div>

                    <div class="my-questions">
                        <div class="card question-element ">
                            <div class="card-status bg-blue br-tr-7 br-tl-7"></div>
                            <div class="card-body">
                                <!-- ROW-1 OPEN -->
                                <div class="row mt-40">
                                    <div class="col-md-6 col-12">
                                        <div class="row neg-m-t-30">
                                            <div class="col-lg-12 ">
                                                <label class="">Question</label>
                                                <button type="button" class="to-kannada btn btn-sm btn-success mt-30"  description-id="qu_description"
                                                    editor-id="content_new">To Kannada</button>
                                                <textarea name="question[]" class="content1" id="content_new" placeholder="Question"></textarea>
                                            </div>

                                        </div>
                                        <br />
                                        <div class="row">
                                            <div class="col-lg-12 m-t-20 ">
                                                <label class="rich-text-editor-lable">Description</label>
                                                <textarea id="qu_description" name="description[]" rows="6" class=" width-full"></textarea>
                                            </div>
                                        </div>


                                    </div>
                                    <div class=" col-md-6 col-12">
                                        <div class="row mt-sm-30">
                                            <div class="col-lg-3 ml-15">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Question Marks </label>
                                                    <input name="marks[]" value="1" class="form-control required"
                                                        placeholder="Marks" required type="text">
                                                </div>
                                            </div>
                                            <div class="col-lg-5 ml-15">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Is Question have Negative Marks
                                                        ?</label>
                                                    <div class="material-switch mt-10 pull-right">
                                                        <input name="is_negative[]" value="1" id="1negative_marking"
                                                            class="negative_marking" type="checkbox" />
                                                        <label for="1negative_marking" class="label-danger"></label>
                                                    </div>
                                                    <input name="negative_marking[]"
                                                        class="form-control negative_marking_input" value="0"
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
                                                    <button type="button" class="to-kannada btn btn-sm btn-success "
                                                        editor-id="answer1-1">To Kannada</button>
                                                    <textarea name="answer1[]" class="answer1" id='answer1-1' placeholder="Option1" required></textarea>
                                                    {{-- <input type="text" name="answer1[]" class="form-control form-input"
                                                        placeholder="Option1" required /> --}}
                                                </div>
                                            </div>
                                            <div class="col-md-1 col-2">
                                                <div class="material-switch mt-10 pull-right">
                                                    <input name="correct[]" value="1" id="1correct1" class="1correct"
                                                        onclick="selectAnswer(this,'1correct')" type="checkbox" checked />
                                                    <label for="1correct1" class="label-primary"></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-1 max-width-2 pt-10">
                                                <h4>2</h4>
                                            </div>
                                            <div class="col-md-10 col-8">
                                                <div class="form-group">
                                                    <button type="button" class="to-kannada btn btn-sm btn-success "
                                                        editor-id="answer2-1">To Kannada</button>
                                                    <textarea name="answer2[]" class="answer" id='answer2-1' placeholder="Option2" required></textarea>
                                                    {{-- <input type="text" name="answer2[]" class="form-control form-input"
                                                        placeholder="Option2" required /> --}}
                                                </div>
                                            </div>
                                            <div class="col-md-1 col-2">
                                                <div class="material-switch mt-10 pull-right">
                                                    <input name="correct[]" value="2" id="1correct2" class="1correct"
                                                        onclick="selectAnswer(this,'1correct')" type="checkbox" />
                                                    <label for="1correct2" class="label-primary"></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-1 max-width-2 pt-10">
                                                <h4>3</h4>
                                            </div>
                                            <div class="col-md-10 col-8">
                                                <div class="form-group">
                                                    <button type="button" class="to-kannada btn btn-sm btn-success "
                                                        editor-id="answer3-1">To Kannada</button>
                                                    <textarea name="answer3[]" class="answer" id='answer3-1' placeholder="Option3"></textarea>
                                                    {{-- <input type="text" name="answer3[]" class="form-control form-input"
                                                        placeholder="Option3" /> --}}
                                                </div>
                                            </div>
                                            <div class="col-md-1 col-2">
                                                <div class="material-switch mt-10 pull-right">
                                                    <input name="correct[]" value="3" id="correct3" class="1correct"
                                                        onclick="selectAnswer(this,'1correct')" type="checkbox" />
                                                    <label for="correct3" class="label-primary"></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-1 max-width-2 pt-10">
                                                <h4>4</h4>
                                            </div>
                                            <div class="col-md-10 col-8">
                                                <div class="form-group">
                                                    <button type="button" class="to-kannada btn btn-sm btn-success "
                                                        editor-id="answer4-1">To Kannada</button>
                                                    <textarea name="answer4[]" class="answer" id='answer4-1' placeholder="Option4"></textarea>
                                                    {{-- <input type="text" name="answer4[]" class="form-control form-input"
                                                        placeholder="Option4" /> --}}
                                                </div>
                                            </div>
                                            <div class="col-md-1 col-2">
                                                <div class="material-switch mt-10 pull-right">
                                                    <input name="correct[]" value="4" id="correct4" class="1correct"
                                                        onclick="selectAnswer(this,'1correct')" type="checkbox" />
                                                    <label for="correct4" class="label-primary"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-1 max-width-2 pt-10">
                                                <h4>5</h4>
                                            </div>
                                            <div class="col-md-10 col-8">
                                                <div class="form-group">
                                                    <button type="button" class="to-kannada btn btn-sm btn-success "
                                                        editor-id="answer5-1">To Kannada</button>
                                                    <textarea name="answer5[]" class="answer" id='answer5-1' placeholder="Option5"></textarea>
                                                    {{-- <input type="text" name="answer5[]" class="form-control form-input"
                                                        placeholder="Option5" /> --}}
                                                </div>
                                            </div>
                                            <div class="col-md-1 col-2">
                                                <div class="material-switch mt-10 pull-right">
                                                    <input name="correct[]" value="5" id="correct5" class="1correct"
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
                                                    <button type="button" class="to-kannada btn btn-sm btn-success "
                                                        editor-id="answer6-1">To Kannada</button>
                                                    <textarea name="answer6[]" class="answer" id='answer6-1' placeholder="Option6"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-1 col-2">
                                                <div class="material-switch mt-10 pull-right">
                                                    <input name="correct[]" value="6" id="correct6" class="1correct"
                                                        onclick="selectAnswer(this,'1correct')" type="checkbox" />
                                                    <label for="correct6" class="label-primary"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
    <div class="new-questions" style="display: none">
        <div class="card question-element mt-30">
            <div class="card-status bg-blue br-tr-7 br-tl-7"></div>
            <div class="ml-auto mt-10 mr-10 delete-question">
                <div class="feature ">
                    <div class="fa-stack  fa-1x border bg-danger mb-3">
                        <i class="fa fa-minus fa-stack-1x text-white"></i>
                    </div>
                </div>
            </div>
            <div class="card-body neg-m-t-20">
                <!-- ROW-1 OPEN -->
                <div class="row ">
                    <div class="col-md-6 col-12">

                        <div class="row neg-m-t-30">
                            <div class="col-lg-12 ">
                                <label class="rich-text-editor-lable">Question</label>
                                <button type="button" class="to-kannada btn btn-sm btn-success mt-30" editor-id="">To
                                    Kannada</button>
                                <textarea name="question[]" class="content_new" placeholder="Question"></textarea>
                            </div>

                        </div>
                        <br />
                        <div class="row">
                            <div class="col-lg-12 m-t-20 ">
                                <label class="rich-text-editor-lable">Description</label>
                                <textarea  name="description[]" class=" width-full qu_description" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="row mt-sm-30">
                            <div class="col-lg-3 ml-15">
                                <div class="form-group">
                                    <label class="font-weight-bold">Question Marks </label>
                                    <input name="marks[]" value="1" class="form-control required" placeholder="Marks"
                                        required>
                                </div>
                            </div>
                            <div class="col-lg-5 ml-15">
                                <div class="form-group">
                                    <label class="font-weight-bold">Is Question have Negative Marks ?</label>
                                    <div class="material-switch mt-10 pull-right">
                                        <input name="is_negative[]" value="1" id="1negative_marking"
                                            class="negative_marking" type="checkbox" />
                                        <label for="1negative_marking" class="label-danger"></label>
                                    </div>
                                    <input name="negative_marking[]" class="form-control negative_marking_input" value="0"
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
                                    <button type="button" class="to-kannada btn1 btn btn-sm btn-success "
                                        editor-id="">To Kannada</button>

                                    <textarea name="answer1[]" class="answer1" id='answer1-1' placeholder="Option1" required></textarea>
                                    {{-- <input type="text" name="answer1[]" class="form-control form-input"
                                        placeholder="Option1" required /> --}}
                                </div>
                            </div>
                            <div class="col-md-1 col-2">
                                <div class="material-switch mt-10 pull-right">
                                    <input id="correct1" name="correct[]" value="1" class="correct"
                                        onclick="selectAnswer(this,'2correct')" type="checkbox" checked />
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
                                    <button type="button" class="to-kannada btn2 btn btn-sm btn-success "
                                        editor-id="">To Kannada</button>

                                    <textarea name="answer2[]" class="answer2" id='answer2-1' placeholder="Option2" required></textarea>
                                    {{-- <input type="text" name="answer2[]" class="form-control form-input"
                                        placeholder="Option2" required /> --}}
                                </div>
                            </div>
                            <div class="col-md-1 col-2">
                                <div class="material-switch mt-10 pull-right">
                                    <input id="correct2" name="correct[]" value="2" class="correct"
                                        onclick="selectAnswer(this,'2correct')" type="checkbox" />
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
                                    <button type="button" class="to-kannada btn3 btn btn-sm btn-success "
                                        editor-id="">To Kannada</button>

                                    <textarea name="answer3[]" class="answer3" id='answer3-1' placeholder="Option3"></textarea>
                                    {{-- <input type="text" name="answer3[]" class="form-control form-input"
                                        placeholder="Option3" /> --}}
                                </div>
                            </div>
                            <div class="col-md-1 col-2">
                                <div class="material-switch mt-10 pull-right">
                                    <input id="correct3" name="correct[]" value="3" class="correct"
                                        onclick="selectAnswer(this,'2correct')" type="checkbox" />
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
                                    <button type="button" class="to-kannada btn4 btn btn-sm btn-success "
                                        editor-id="">To Kannada</button>

                                    <textarea name="answer4[]" class="answer4" id='answer4-1' placeholder="Option4"></textarea>
                                    {{-- <input type="text" name="answer4[]" class="form-control form-input"
                                        placeholder="Option4" /> --}}
                                </div>
                            </div>
                            <div class="col-md-1 col-2">
                                <div class="material-switch mt-10 pull-right">
                                    <input id="correct4" name="correct[]" value="4" class="correct"
                                        onclick="selectAnswer(this,'2correct')" type="checkbox" />
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
                                    <button type="button" class="to-kannada btn5 btn btn-sm btn-success "
                                        editor-id="">To Kannada</button>

                                    <textarea name="answer5[]" class="answer5" id='answer5-1' placeholder="Option5"></textarea>
                                    {{-- <input type="text" name="answer5[]" class="form-control form-input"
                                        placeholder="Option5" /> --}}
                                </div>
                            </div>
                            <div class="col-md-1 col-2">
                                <div class="material-switch mt-10 pull-right">
                                    <input id="correct5" name="correct[]" value="5" class="correct"
                                        onclick="selectAnswer(this,'2correct')" type="checkbox" />
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
                                    <button type="button" class="to-kannada btn6 btn btn-sm btn-success "
                                        editor-id="">To Kannada</button>
                                    <textarea name="answer6[]" class="answer6" id='answer6-1' placeholder="Option6"></textarea>
                                </div>
                            </div>
                            <div class="col-md-1 col-2">
                                <div class="material-switch mt-10 pull-right">
                                    <input id="correct6" name="correct[]" value="6" class="correct"
                                        onclick="selectAnswer(this,'2correct')" type="checkbox" />
                                    <label for="correct6" class="label-primary"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a class="fixed-bottom-right add-question">
        <i class="fa fa-plus fa-2x"></i>
    </a>
    {{ Html::script('assets/plugins/ckeditor/ckeditor.js') }}
    {{ Html::script('js/dependent_check_out_larvela.js') }}
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
        window.new_row = 1
        var date = new Date();
        var month = date.getMonth() + 1;
        var day = date.getDate();
        var today = (day < 10 ? '0' : '') + day + '-' + (month < 10 ? '0' : '') + month + '-' + date.getFullYear();
        $('.fc-datepicker').val(today)

        function selectAnswer(curr, chkClass) {
            chkClass = $(curr).attr('class')
            $("." + chkClass).prop("checked", false);
            $(curr).prop("checked", true);
        }

        $('#Subject-subject').on('change', function() {
            course = $(this).val();
        })

        $('.add-question').on('click', function() {
            qu_count = window.new_row
            window.new_row = window.new_row + 1
            new_row = window.new_row
            tot_row = $('.my-questions > div').length + 1
            tot_row = String(tot_row).padStart(2, '0')
            $('.counter-div').html(tot_row)
            $('#total_questions').val(tot_row);

            $('.my-questions').prepend($('.new-questions').html())
            $('.my-questions').eq(0).find('.content_new').attr('id', 'content_new' + qu_count)
            $('.my-questions').eq(0).find('.to-kannada').attr('editor-id', 'content_new' + qu_count)
            $('.my-questions').eq(0).find('.to-kannada').attr('description-id', 'qu_description' + qu_count)
            $('.my-questions').eq(0).find('.qu_description').attr('id', 'qu_description' + qu_count)
            $('.my-questions').find('.question-element').first().attr('id', 'question-element' + new_row)
            $('.new-questions').find('.content_new')
            //$('#content_new' + qu_count).richText(editorConfig);
            CKEDITOR.replace('content_new' + qu_count, {
                toolbarGroups: toolbarGp,
                removePlugins: 'elementspath',
                resize_enabled: true,
                allowedContent: true,
            });

            toogle_class = ".correct"
            neg_mark_class = ".negative_marking"
            neg_mark_input_class = ".negative_marking_input"
            card_togle_btn = $('#question-element' + new_row).find(toogle_class)
            neg_mark_btn = $('#question-element' + new_row).find(neg_mark_class)
            neg_mark_input = $('#question-element' + new_row).find(neg_mark_input_class)
            $(neg_mark_btn.next()).attr('for', new_row + "negative_marking")
            $(neg_mark_btn).attr('id', new_row + "negative_marking")
            $(neg_mark_input).attr('id', new_row + "negative_marking_input")
            //$(neg_mark_input).attr('name', "negative_marking[" + qu_count + "]")
            //console.log(neg_mark_btn.next())
            for (i = 0; i < card_togle_btn.length; i++) {
                lable = $(card_togle_btn[i].nextElementSibling)
                chk_bok = $(card_togle_btn[i])
                j = i + 1

                $(chk_bok).attr('id', new_row + "correct" + j)
                $(lable).attr('for', new_row + "correct" + j)
            }
            $('#question-element' + new_row).find(toogle_class).addClass(new_row + 'correct')
            $('#question-element' + new_row).find(toogle_class).removeClass('correct')
            var i = 1;
            for (var i = 1; i <= 6; i++) {

                var cls = 'answer' + i;
                var newId = cls + '-' + qu_count;
                console.log(newId);
                $('.my-questions').eq(0).find('.' + cls).attr('id', newId);
                $('.my-questions').eq(0).find('.btn' + i).attr('editor-id', newId);


                CKEDITOR.replace(newId, {
                    toolbarGroups: toolbarGp,
                    height: '80px',
                    removePlugins: 'elementspath',
                    resize_enabled: true,
                    allowedContent: true,
                });
            }

        });
        $('body').on('click', '.delete-question', function() {
            $(this).parent('.card').remove()
            tot_row = $('.my-questions > div').length
            tot_row = String(tot_row).padStart(2, '0')
            $('.counter-div').html(tot_row)
            $('#total_questions').val(tot_row);
        });
        $('body').on('click', '.negative_marking', function() {
            var new_row = $(this).attr('id')+"_input"
            if ($(this).is(':checked')) {
                $("#" + new_row ).val(1)
                $("#" + new_row ).attr("readonly", false);
                return

            }
            $("#" + new_row ).attr("readonly", true);
            $("#" + new_row ).val(0)

        });
        $('#Course-course').on('change', function() {
            var dataVal = $(this).val()

            if (dataVal == '-1') {

                $('.search_dropdown').closest('div').css('display', 'none')
                $('.search_dropdown').removeAttr('required', 'required')
            } else {
                $('.search_dropdown').closest('div').css('display', 'block')
                $('.search_dropdown').attr('required', 'required')
            }
        })


        CKEDITOR.replace('content_new', {
            toolbarGroups: toolbarGp,
            removePlugins: 'elementspath',
            resize_enabled: true,
            // Allow pasting any content.
            allowedContent: true,
        });

        for (var i = 1; i <= 6; i++) {
            var id = 'answer' + i + '-1';
            //$('#'+id).richText(editor1cfg);
            //	 $('#'+id).richText(editorConfig);

            CKEDITOR.replace(id, {
                toolbarGroups: toolbarGp,
                height: '80px',
                removePlugins: 'elementspath',
                resize_enabled: true,
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
@endsection
