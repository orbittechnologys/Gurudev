@extends('layout.adminMain')
@section("title","Chapter List")
@section("content")
    <div class="app-content1">
        <div class="row  mt-30" id="user-profile">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Chapter List</div>
                        <div class="card-options">
                            <div class="pull-right">
                                <a href="{{url('admin/chapter')}}"  data-toggle="tooltip" data-original-title="Study Material" class="btn btn-info btn-icon text-white mr-2">
                                    <span><i class="fe fe-plus"></i></span> Add
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="dynamic_table_list"
                                           class="table table-hover text-nowrap table-striped table-bordered text-nowrap w-100">
                                        <thead class="bg-blue">
                                        <tr class="hidden-row">
                                            <th>#</th>
                                            <th class="min-100">Action</th>
                                            <th class="min-100">Status</th>
                                            <th class="min-100">Course</th>
                                            <th class="min-100">Subject</th>
                                            <th class="min-100">Chapter</th>
                                            <th >Type</th>
                                            <th >Publish Date</th>
                                            <th class="min-100"> Amount</th>

                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('includeJs')
    @include('includes.CssJs.dataTable')
    @include('includes.CssJs.advanced_form')
    @include('includes.Print.print')
    <script>
        $(function () {
            "use strict";
            $('.content-area').addClass('container-fluid')
            $('.content-area').removeClass('container')
            $('.select2.select2-container').remove();


            var quaryUrl = '{{url("admin/chapter/list")}}'
            var recordsTotal = 0

            if ($.fn.DataTable.isDataTable('#dynamic_table_list')) {
                $('#dynamic_table_list').DataTable().destroy();
            }
            $('#dynamic_table_list thead tr:eq(0) th').each(function (i) {
                //console.log($(this).html());
                if ($(this).html() != 'Action')
                    $("#printTbl>thead>tr:eq(1)").append("<th>" + $(this).html() + "</th>");
                if (i == 0) {
                    $(this).html('#');
                } else if (i == 3) {
                    $(this).html('{{ Form::select('course_id',$course,null,['class'=>'select2-show-search required get-next-child','id'=>'Subject-subject','required',"placeholder"=>"Course"])}}');
                }else if (i == 4) {
                    $(this).html('{{ Form::select('subject_id',[],null,['class'=>'required select2-show-search search_dropdown Subject-subject','required',"placeholder"=>"Subject"])}}');
                }else if (i == 5) {
                    $(this).html('{{ Form::text('chapter',null,['class'=>'form-control required','placeholder'=>'Chapter Name','required']) }}');
                }
                else if (i == 6) {
                    $(this).html('{{ Form::select('status',["Free"=>"Free","Paid"=>"Paid"],null,['class'=>'select2-selection','required',"placeholder"=>"Subject Type"])}}');
                }   else {
                }
                $('input, select', this).on('keyup change', function () {
                    if (window.table.column(i).search() !== this.value) {
                        window.table
                            .column(i)
                            .search(this.value, true, false)
                            .draw();
                    }
                });
                $('.select2-show-search').select2({
                    minimumResultsForSearch: ''
                });
            });


            var dataTable = $('#dynamic_table_list').DataTable({
                'responsive': false,
                'autoWidth': false,
                'filter': true,
                'info': true,
                "sDom": "Btlipr",
                "processing": true,
                "serverSide": true,
                "pagingType": "full_numbers",
                "lengthChange": true,
                "ordering": false,

                "ajax": {
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: quaryUrl,
                    type: "POST",
                    data: function (data) {
                        data.recordsTotal = recordsTotal

                    },
                    /*success: function (data) { console.log(data)  },*/
                    error: function (data) {

                    }, complete: function (data) {
                        recordsTotal = data.responseJSON.recordsTotal
                        $('[data-toggle="tooltip"]').tooltip({
                            container: 'body'
                        });
                    }

                },
                columnDefs: [{
                    targets: 1,
                    sClass: "text-left",
                    render: function (data, type, full) {
                        if (data) {
                            var edit = '{{url('admin/chapter')}}/' + data
                            var material = '{{uploads('')}}' + full[9]
                            var videomaterial = full[10]
                            var mockTest = '{{url('admin/mockTest/add')}}/' + data
                            var result = `<a href="JavaScript:void(0);"   class="table_icons" data-toggle="tooltip" data-original-title="Delete" ><i data-id="` + data + `" class="ti ti-trash"  aria-hidden="true"></i></a>`
                                result += `<a href="`+edit+`"   class="table_icons" data-toggle="tooltip" data-original-title="Edit" ><i  class="ti ti-pencil"  aria-hidden="true"></i></a>`
                                if(full[9]!=='')
                                    result += `<a href="`+material+`" target="_blank"   class="table_icons" data-toggle="tooltip" data-original-title="Study Material" ><i  class="ti ti-file"  aria-hidden="true"></i></a>`
                                if(full[10]!=='')
                                    result += `<a href="`+videomaterial+`" target="_blank"   class="table_icons"  ><i data-toggle="tooltip" data-original-title="Video Material"  class="ti ti-video-camera"  aria-hidden="true"></i></a>`

                                result += `<a href="`+mockTest+`"  class="table_icons"  ><i data-toggle="tooltip" data-original-title="Mock Test"  class="fa fa-question-circle-o"  aria-hidden="true"></i></a>`

                            return `<ul class="notifications">` + result + `</ul>`;
                        }
                        return '';
                    },
                },
                    {
                    targets: 2,
                    sClass: "text-left",
                    render: function (data, type, full) {
                        let result=''
                        if(data=='Inactive') {
                            result = `<a href="JavaScript:void(0);" class="btn btn-outline-danger update-status" data-toggle="tooltip" data-original-title="Chapter is Inactive" data-val='Active' data-id="` + full[1] + `" >Inactive</a>`;

                        }
                        else if(data=='Active') {
                            result = `<a href="JavaScript:void(0);" class="btn btn-outline-success update-status" data-toggle="tooltip" data-original-title="Chapter is Active" data-val='Inactive' data-id="` + full[1] + `" >Active</a>`;

                        }
                        return result;
                    },
                },
                   ],

                aLengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, 'All']

                ],
                iDisplayLength: 10,
            })
            window.table = dataTable;
            $('#dynamic_table_list .fc-datepicker').datepicker({
                showOtherMonths: true,
                selectOtherMonths: true,

                changeMonth: true,
                changeYear: true,
                yearRange: '1960:2040',
                todayHighlight: true,
                trackSelectedDate: true,
                dateFormat: "dd-mm-yy"

            });
            $('#dynamic_table_list').on('click', '.ti-trash', function () {
                if (!confirm('Are you sure you want to delete???')) {
                    return false;
                }
                var id = $(this).attr('data-id');
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    data: {
                        'formType': 'Delete',
                        'id': id,
                    },
                    url: quaryUrl,
                    dataType: 'json',
                    success: function (data) {
                        if (data == "success") {
                            dataTable.ajax.reload(null, false);
                            $(this).showAlert('danger', 'Record Deleted Successfully')
                        } else {
                            $(this).showAlert('danger', 'Invalid Field')
                        }
                    },
                    error: function (data) {

                    }
                });

            });
            $('#dynamic_table_list').on('click', '.update-status', function () {
                var table_row = $(this).parents('tr');
                var id = $(this).attr('data-id');
                let status=$(this).attr('data-val');
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    data: {'formType': 'Status', 'id': id,'status':status},
                    url: quaryUrl,
                    dataType: 'json',
                    success: function (data) {
                        if (data) {
                            window.table.row($(table_row)).remove().draw();
                            $(this).showAlert('danger', 'Status Updated Successfully')

                        } else {
                            $(this).showAlert('danger', 'Invalid Form Data')
                        }
                    }, error: function (data) {
                        $(this).showAlert('danger', 'invalid field data')
                    }
                });
            })


        });
    </script>
@endpush