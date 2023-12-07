@extends('layout.adminMain')
@section('title', 'SMS Details')

@section('content')
    <style>
        .span-input {
            min-width: 50px;
            width: 100px;
            min-height: 30px;
            display: inline-block;
            border-radius: 5px;
            padding: 5px;
            background-color: #d2d2df
        }

        .span-input :before {
            content: "\200D";
            display: inline;
        }
    </style>
    <div class="row  mt-30" id="user-profile">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">SMS Details</div>
                    <div class="card-options">

                        <div class="clearfix pull-right d-flex">
                            <a href="{{ url('smsTemplate') }}" class="mr-2 btn btn-instagram wrap">Add SMS Template</a>
                        </div>
                        <div class="clearfix pull-right d-flex">
                            <button type="button" class="mr-2 btn btn-teal wrap" id="quickSmsBtn">Quick SMS</button>
                        </div>

                        <div class="clearfix pull-right d-flex">
                            <a href="{{ url('sms_individual') }}" class="mr-2 btn btn-facebook wrap"
                                id="classWiseSmsBtn">Student wise SMS</a>
                        </div>

                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="dynamic_table_list" class="table table-striped table-bordered w-100">
                            <thead class="bg-blue">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Date</th>
                                    <th>SMS Type</th>
                                    <th>Status</th>
                                    <th style='width:300px'>Message</th>
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


    <!--********************** Quick SMS Modal Start *********************-->
    <div class="modal" id="quickSmsModal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Quick SMS</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                {{ Form::model($model = null,['id'=>'quickSmsForm']) }}
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Numbers</label>
                                {{ Form::hidden('sms_type', 'Quick') }}
                                {{ Form::hidden('message', null, ['id' => 'final-message', 'required']) }}

                                {{ Form::textarea('number', null, ['class' => 'form-control required mobile_no', 'rows' => '4', 'placeholder' => '9845006985,87458069521','required']) }}
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>SMS Templates</label>
                                {{ Form::select('templates', $templates, null, ['class' => 'select2 required template', 'required', 'placeholder' => 'Templates']) }}

                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Message</label><span class="text-danger"> (White spaces are not allowed)</span>
                                <div id="message" class="form-control" style="height: 100px"></div>
                                <span class="text-danger message"></span>
                            </div>
                        </div>


                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <a href="javascript:void(0)" class="btn btn-success" id="quick_sms_btn">Save</a>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <!--********************** Quick SMS Modal End *********************-->

    @endsection
    @push('includeJs')
        @include('includes.CssJs.dataTable')
        @include('includes.CssJs.advanced_form')
        @include('includes.Print.print')
        <script>
            $('#quickSmsBtn').click(function() {
                $('#number').val('');
                $('#quickSmsModal').modal().show();
            });

        </script>
        <script>
            var quaryUrl = '{{ url('smsListAjax') }}'
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
                } else if (i == 1) {
                    $(this).html(
                        '{{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name']) }}');
                } else if (i == 4) {
                    $(this).html(
                        '{{ Form::select('type', ['Quick' => 'Quick', 'Individual' => 'Individual'], null, ['class' => 'form-control select2 ', 'placeholder' => 'Type']) }}'
                    );
                } else if (i == 5) {
                    $(this).html(
                        '{{ Form::select('type', ['Success' => 'Success', 'failure' => 'Failed'], null, ['class' => 'form-control select2', 'placeholder' => 'Status']) }}'
                    );
                } else if (i == 2) {
                    $(this).html(
                        '{{ Form::text('qty', null, ['class' => 'form-control ', 'placeholder' => 'Mobile']) }}');
                } else if (i == 3) {
                    $(this).html(
                        '{{ Form::text('qty', null, ['class' => 'form-control dateRangePickerInput', 'placeholder' => 'Payment Date']) }}'
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
                columnDefs: [{
                    targets: 6,
                    sClass: "text-left",
                    render: function(data, type, full) {
                        return `<div data-container="body" data-toggle="tooltip" data-popover-color="default" data-placement="left"  data-original-title="` +
                            full[7] + `">` + data + `</div>`;
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
                aLengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, 'All']

                ],
                iDisplayLength: 10,
            })
            window.table = dataTable;

            $('.template').on('change', function() {
                let template = $(this).val()
                for (i = 1; i < 10; i++)
                    template = template.replace('input' + i, 'input');
                templateArr = template.split('input')
                mesg = '';
                for (i = 0; i < templateArr.length; i++) {
                    mesg += templateArr[i];
                    if ((i + 1) != templateArr.length)
                        mesg += `<span contenteditable class="span-input"></span>`

                }
                $('#message').html(mesg)

            })
            $('#quick_sms_btn').on('click', function() {
                var template = $(".template option:selected").text();
                var mobile_no = $(".mobile_no").val();

                if (template == 'Templates') {
                    alert('Please select SMS Template')
                    return false;
                } else if ($('#message').text() == '') {
                    $('.message').text('Message was not be Empty..!');
                    return false;
                }
                else if (mobile_no == '') {
                    alert('Please Enter Mobile Numbers.')
                    return false;
                }
                $('#final-message').val($('#message').text())
                $('#quickSmsForm').submit()
            })
        </script>
    @endpush
