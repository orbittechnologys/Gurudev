@extends('layout.adminMain')
@section("title"," Study Material List")


@section("content")
    <style>
        .bradius{
            object-fit: cover;
        }
    </style>
    @php($type=app('request')->input('type'))
    <?php if($type=='Video'){
        $iconType='video-camera';
    }
    else{
        $iconType='file';
    }?>

    <div class="app-content1">
        <div class="row  mt-30" id="user-profile">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{$type}} Material List</div>
                        <div class="card-options">
                            <div class="pull-right">

                                <a href="{{url('admin/material?type='.$type)}}" class="btn btn-info btn-icon text-white mr-2">
                                    <span><i class="fe fe-plus"></i></span> Add {{$type}} Material
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
                                            <th class="min-100">Title</th>
                                            <th style="min-width: 189px;">Publish Date</th>
                                            <th class="min-100">Tags</th>
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

            var quaryUrl = '{{url("admin/material/list?type=".$type)}}'
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
                } else if (i == 2) {
                    $(this).html('{{Form::text("name",null,["class"=>"form-control","placeholder"=>"Title"])}}');
                } else if (i == 3) {
                    $(this).html('{{Form::text("date",null,["class"=>"form-control fc-datepicker","placeholder"=>"Date"])}}');
                }  else if (i == 4) {
                    $(this).html('{{Form::text("qty",null,["class"=>"form-control","placeholder"=>"Tags"])}}');
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
                    targets: 1,
                    sClass: "text-left",
                    render: function (data, type, full) {
                        if (data) {
                            var edit = '{{url('admin/material/?type='.$type.'&id=')}}' + data
                            var material = '{{uploads('')}}/' + full[5]
                            var result = `<a href="JavaScript:void(0);"   class="table_icons" data-toggle="tooltip" data-original-title="Delete" ><i data-id="` + data + `" class="ti ti-trash"  aria-hidden="true"></i></a>`
                             result += `<a href="`+edit+`"   class="table_icons" data-toggle="tooltip" data-original-title="Edit" ><i  class="ti ti-pencil"  aria-hidden="true"></i></a>`;

                            if(full[5]!=''){ 
                                result += `<a href="`+full[5]+`" target="_blank"   class="table_icons" data-toggle="tooltip" data-original-title="{{$type}} Material" ><i  class="ti ti-{{$iconType}}"  aria-hidden="true"></i></a>`
                            }
                            if(full[6]!=''){ 
                                result += `<a href="`+full[6]+`" target="_blank"   class="table_icons" data-toggle="tooltip" data-original-title="{{$type}} Material" ><i  class="ti ti-{{$iconType}}"  aria-hidden="true"></i></a>`
                            }

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


        });
    </script>
@endpush
