@extends('layout.adminMain')
@section('title','Special Test List')
@push('includeJs')
    <style>
        .question div, h1, h2, h3, h4, h5 {
            display: inline;
        }


        hr.question-details {
            border-top: 1px dotted red;
            width: 100%;
            margin: 10px 0;
            padding: 0;
        }

        .richText .richText-editor {
            height: 100px !important;
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

        .global_search{
            width: 500px;
        }

    </style>
    @include('includes.CssJs.advanced_form')
@endpush

@section('content')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-home mr-1"></i>{{$cardTitle}}</a></li>

        </ol>
        <div class="ml-auto">
            <div class="input-group input-search">
                <div class="input-group-append">
                    <input  style="height: 1px; width:0px; border: 0px;" class="datepicker">
                    <button  class="fc-datepicker-btn btn btn-date bg-white" type="button" id="button-addon3" ><i class="ti ti-calendar"></i> </button>

                </div>
                {{ Form::text('global_search',null,['style'=>'width: 350px;','class'=>' form-control global_search ','placeholder'=>'Enter Question Or Tags to filter']) }}

            </div>
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

                    </div>
                </div>
            </div>
        </div>
    </div>

    <a class="fixed-bottom-right" href="{{url($addUrl)}}">
        <i class="fa fa-plus fa-2x"></i>
    </a>


@endsection
@push('includeJs')
    {!! Html::style('assets/plugins/jquery.richtext/jquery.richtext.css')!!}
    {{ Html::script("assets/plugins/jquery.richtext/jquery.richtext.js") }}
    {{ Html::script("assets/plugins/jquery.richtext/wysiwyag.js") }}

    <script>
        $('.datepicker').datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            changeMonth: true,
            changeYear: true,
            yearRange: '1960:2040',
            todayHighlight: true,
            trackSelectedDate:true,
            dateFormat: "dd-mm-yy",
            onSelect: function(date) {
                $(".global_search").val(date);
                $('.global_search').trigger('input');
            },

        });
        $('.fc-datepicker-btn').click(function () {
            $('.datepicker').datepicker('show');
        })
        $('#questions_load').load('{{url($current_route) }}?searchString=all');
        var url='{{ url($current_route) }}'
        function myPagination(page,type) {
            if (type) {
                split_str = page.split('=');
                page = split_str[1];
            }
            search_string = $('.global_search').val();
            if(search_string==='')search_string='all'
            $('#questions_load').load(url+'?searchString='+encodeURIComponent(search_string) + '&page=' + page);
        }
        $('.global_search').on('input',function () {
            search_string = $(this).val();
            if(search_string.length>0){
                $('#questions_load').load(url+'?searchString='+encodeURIComponent(search_string));
            }
            else   $('#questions_load').load(url+'?searchString=all');
        })
    </script>
    <script>
        $('#question_search').click(function () {
            $('#nav-search-bar').css('display', 'block');
            $('.header-search').focus();
            //console.log($(window).width());
            if ($(window).width() <= 767) {
                // $('.search-icon').click();
                $('.navsearch').click();
                // alert("da")
            }
        });
    </script>
    <script>

        function quiz_attended(id) {
            window.location.href = '{{url('/admin/quiz/attended/')}}/' + id;
        }


        $("#questions_load").on("click",".confirm-delete_quiz", function (e) {
            e.preventDefault();
            var tthis = $(this);
            return swal({
                title: "Alert",
                text: "Are you really want to delete Record",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }, function (isConfirm) {
                if (isConfirm) {

                    $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    data: {
                        'id': tthis.attr('id'),
                    },
                    url: '{{url("admin/quiz/delete")}}',
                    dataType: 'json',
                    success: function (data) {
                        if (data == "success") {
                            myPagination(tthis.attr('data-page'))
                            $(this).showAlert('danger', 'Record Deleted Successfully')
                        } else {
                            $(this).showAlert('danger', 'Invalid Field')
                        }
                    },
                    error: function (data) {

                    }
                });
                }
            });
        });

        function quiz_detail(id) {
            window.location.href = '{{url('admin/quiz/view')}}/' + id;
        }

    </script>
@endpush
