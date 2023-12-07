@extends('layout.adminMain')
@section('title', 'User List')
@push('includeJs')
    @include('includes.CssJs.dataTable')
    @include('includes.CssJs.advanced_form')
    @include('includes.CssJs.table-export-btn')
    @include('includes.Print.print')
@endpush

@section('content')
    <style>
        .bradius {
            object-fit: cover;
        }
    </style>
    <div class="app-content1">
        <div class="row  mt-30" id="user-profile">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">User List</div>
                        <div class="card-options">
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#manual_payment"
                                class="btn btn-primary">Upload Excel</a>
                            <a href="{{ uploads('Uploads/GurudevUserTemplete.xlsx') }}" download=""
                                class="btn btn-danger ml-5">Download Template</a>
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
                                                <th style="min-width: 189px;">Name/User ID</th>
                                                <th style="min-width: 189px;">Dob</th>
                                                <th class="min-100">Email</th>
                                                <th class="min-100">Mobile</th>
                                                <th class="min-100">Registered</th>
                                                <th class="min-100">City</th>
                                                <th class="min-100">Zipcode</th>


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
                    <h6 class="modal-title">Upload Excel </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{ Form::model('', ['url' => '/admin/importUser', 'method' => 'post', 'files' => true]) }}
                <div class="modal-body pd-20">

                    <div class="row ">
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::file('file', null, ['class' => 'form-control', 'required', 'accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel', 'placeholder' => 'User ']) }}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    {{ Form::submit('Upload', ['class' => 'btn btn-primary']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    @if ($recordsMissed = Session::get('missed-records'))
        <div class="modal" id="importMissed">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-white">
                    <div class="modal-header">
                        <h4 class="modal-title">Missed User s</h4>
                        <a type="button" class="close" data-dismiss="modal">&times;</a>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered tbl-view-more">
                                        <thead class="bg-azure">
                                            <tr>
                                                <th class="text-white">#</th>
                                                <th class="text-white">Name</th>
                                                <th class="text-white">Mobile</th>
                                                {{-- <th>DOB</th> --}}
                                                <th class="text-white">Email Id</th>
                                                <th class="text-white">Error</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($recordsMissed as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item[0] }}</td>
                                                    <td>{{ $item[1] }}</td>
                                                    {{-- <td>{{ $item[2] }}</td> --}}
                                                    <td>{{ $item[3] }}</td>
                                                    <td class="text-danger text-nowrap">{{ $item['error'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@push('includeJs')
    <script>
        $(function() {
            "use strict";
            $('.content-area').addClass('container-fluid')
            $('.content-area').removeClass('container')
            $('.select2.select2-container').remove();
            var quaryUrl = '{{ url('admin/users') }}'
            var recordsTotal = 0

            if ($.fn.DataTable.isDataTable('#dynamic_table_list')) {
                $('#dynamic_table_list').DataTable().destroy();
            }
            $('#dynamic_table_list thead tr:eq(0) th').each(function(i) {
                //console.log($(this).html());
                if ($(this).html() != 'Action')
                    $("#printTbl>thead>tr:eq(1)").append("<th>" + $(this).html() + "</th>");
                if (i == 0) {
                    $(this).html('#');
                } else if (i == 2) {
                    $(this).html(
                        '{{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name/User Id']) }}'
                    );
                } else if (i == 3) {
                    $(this).html(
                        '{{ Form::text('dob', null, ['class' => 'form-control ', 'placeholder' => 'DOB']) }}'
                        );
                } else if (i == 4) {
                    $(this).html(
                        '{{ Form::text('email', null, ['class' => 'form-control ', 'placeholder' => 'Email']) }}'
                    );
                } else if (i == 5) {
                    $(this).html(
                        '{{ Form::text('qty', null, ['class' => 'form-control', 'placeholder' => 'Mobile']) }}'
                    );
                } else if (i == 6) {
                    $(this).html(
                        '{{ Form::text('qty', null, ['class' => 'form-control fc-datepicker', 'placeholder' => 'Registered Date']) }}'
                    );
                } else if (i == 7) {
                    $(this).html(
                        '{{ Form::text('qty', null, ['class' => 'form-control ', 'placeholder' => 'City']) }}'
                    );
                } else if (i == 8) {
                    $(this).html(
                        '{{ Form::text('qty', null, ['class' => 'form-control ', 'placeholder' => 'Zipcode']) }}'
                    );
                } else {}
                $('input, select', this).on('keyup change', function() {
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
                buttons: [{
                    extend: 'excel',
                    exportOptions: {
                        columns: ':visible:not(:eq(1))',
                        format: {
                            header: function(html, idx, node) {

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


                }, ],
                "ajax": {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: quaryUrl,
                    type: "POST",
                    data: function(data) {
                        data.recordsTotal = recordsTotal

                    },
                    /*success: function (data) { console.log(data)  },*/
                    error: function(data) {

                    },
                    complete: function(data) {
                        recordsTotal = data.responseJSON.recordsTotal
                        $('[data-toggle="tooltip"]').tooltip({
                            container: 'body'
                        });
                    }

                },

                columnDefs: [{
                        targets: 1,
                        sClass: "text-left",
                        render: function(data, type, full) {
                            if (data) {

                                var result =
                                    `<a href="JavaScript:void(0);"   class="table_icons" data-toggle="tooltip" data-original-title="Delete" ><i data-id="` +
                                    data + `" class="ti ti-trash"  aria-hidden="true"></i></a>`
                                if (full[10] == 'Active') {
                                    result += `<button data-id="` + data +
                                        `" data-status="InActive" class='btn btn-success change-status'>Active</button>`;
                                } else {
                                    result += `<button data-id="` + data +
                                        `" data-status="Active" class='btn btn-danger change-status'>InActive</button>`;
                                }
                                result = `<ul class="notifications">` + result + `</ul>`;

                                return result
                            }
                            return '';
                        },
                    },
                    {
                        targets: 2,
                        sClass: "text-left",
                        render: function(data, type, full) {
                            if (data) {
                                let assetUrl = '{{ uploads('') }}'
                                let imgSrc = assetUrl  + full[9]
                                let errSrc = assetUrl + 'Uploads/default.jpg'
                                return `<div style='display:flex'><img class="avatar bradius mr-2" src=` +
                                    imgSrc + ` onerror='this.src="` + errSrc +
                                    `"'\><div style="padding-top: 5px;">` + data + `</div></div>`;
                            }
                            return '';
                        },
                    }
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
            $('#dynamic_table_list').on('click', '.ti-trash', function() {
                if (!confirm('Are you sure you want to delete???')) {
                    return false;
                }
                var id = $(this).attr('data-id');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: {
                        'formType': 'Delete',
                        'id': id,
                    },
                    url: quaryUrl,
                    dataType: 'json',
                    success: function(data) {
                        if (data == "success") {
                            dataTable.ajax.reload(null, false);
                            $(this).showAlert('danger', 'Record Deleted Successfully')
                        } else {
                            $(this).showAlert('danger', 'Invalid Field')
                        }
                    },
                    error: function(data) {

                    }
                });

            });
            $('#dynamic_table_list').on('click', '.change-status', function() {
                var id = $(this).attr('data-id');
                status = $(this).attr('data-status')
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: {
                        'formType': 'Update',
                        'id': id,
                        'status': status
                    },
                    url: quaryUrl,
                    dataType: 'json',
                    success: function(data) {
                        if (data == "success") {
                            dataTable.ajax.reload(null, false);
                            $(this).showAlert('danger', 'Status Changed Successfully')
                        } else {
                            $(this).showAlert('danger', 'Invalid Field')
                        }
                    },
                    error: function(data) {

                    }
                });

            });

            $(document).ready(function() {
                var missedRecods = "<?php echo Session::get('missed-records'); ?>"
                if (missedRecods) {
                    $('#importMissed').modal('show');
                }
            });
        });
    </script>
@endpush
