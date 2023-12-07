@extends('layout.adminMain')
@section("title","Payment List")


@section("content")
    <style>
        .bradius{
            object-fit: cover;
        }
    </style>
    <div class="app-content1">
        <div class="row  mt-30" id="user-profile">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Payment Details</div>
                        <div class="card-options">
                            <a href="javascript:void(0)"  data-toggle="modal" data-target="#manual_payment" class="btn btn-primary">Manual Payment</a>
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
                                            <th class="min-100">Name</th>
                                            <th class="min-100">Payment Date</th>
                                            <th class="min-100">Amount</th>
                                            <th style="min-width: 189px;">Payment For</th>
                                            <th style="min-width: 189px;">Payment Course</th>
                                            <th class="min-100">Payment Mode</th>
                                            <th class="min-100">Payment Id</th>
                                            <th class="min-100">Action</th>

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
    <!-- LARGE MODAL For Quiz Questions Edit -->
    <div id="manual_payment" class="modal fade">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content ">
                <div class="modal-header pd-x-20">
                    <h6 class="modal-title">Manual Payment</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{ Form::model('',array('url'=>'/admin/payAmount', 'method' => 'post',))}}
                <div class="modal-body pd-20">

                    <div class="row ">
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::select('user_id',$users,null,['class'=>'form-control select2-show-search search_dropdown ','required','id'=>'course_id','placeholder'=>'User ']) }}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::select('course_id',$course,null,['class'=>'form-control select2-show-search search_dropdown ','required','id'=>'course_id','placeholder'=>'Course']) }}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::text('amount','',['class'=>'form-control ','id'=>'date','required','placeholder'=>'amount']) }}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {{ Form::submit('Save',['class'=>'btn btn-primary']) }}
                </div>
                {{ Form::close() }}
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
            var quaryUrl = '{{url("admin/usersPaymentList")}}'
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
                } else if (i == 1) {
                    $(this).html('{{Form::text("name",null,["class"=>"form-control","placeholder"=>"Name"])}}');
                } else if (i == 4) {
                    $(this).html('{{Form::text("email",null,["class"=>"form-control ","placeholder"=>"Payment For"])}}');
                }  else if (i == 5) {
                    $(this).html('{{Form::text("qty",null,["class"=>"form-control","placeholder"=>"Payment Course Name"])}}');
                }else if (i == 3) {
                    $(this).html('{{Form::text("qty",null,["class"=>"form-control ","placeholder"=>"Amount"])}}');
                }else if (i == 6) {
                    $(this).html('{{Form::text("qty",null,["class"=>"form-control ","placeholder"=>"Payment Mode"])}}');
                }else if (i == 2) {
                    $(this).html('{{Form::text("qty",null,["class"=>"form-control dateRangePickerInput","placeholder"=>"Payment Date"])}}');
                }  else {
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
                buttons: [
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':visible:not(:eq(1))',
                            format: {
                                header: function (html, idx, node) {

                                    if ($('input', node).length) {
                                        return $('input', node).attr('placeholder');
                                    } else if ($('select', node).length) {
                                        return $('select', node).find('option:selected').text()
                                    } else {
                                        return html
                                    }

                                }
                            }
                        },


                    },
                ],
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
                    targets: 8,
                    sClass: "text-left",
                    render: function (data, type, full) {
                        if (full[6]=="Manual") {

                            var result = `<a href="JavaScript:void(0);"   class="table_icons" data-toggle="tooltip" data-original-title="Delete" ><i data-id="` + data + `" class="ti ti-trash"  aria-hidden="true"></i></a>`

                            return `<ul class="notifications">` + result + `</ul>`;
                        }
                        return '';
                    },
                }],
                aLengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, 'All']

                ],
                iDisplayLength: 10,
            })
            window.table = dataTable;

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


        });
    </script>
@endpush
