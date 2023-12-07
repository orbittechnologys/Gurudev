@extends('layout.adminMain')
@section("title","User Role List")
@section('pagespecificstyle')
    @include('includes.CssJs.dataTable')
    @include('includes.CssJs.advanced_form')
@endsection

@section("content")



{!! Html::style('assets/plugins/tabs/tabs.css') !!}
{!! Html::script('assets/plugins/sweet-alert/sweetalert.min.js') !!}
<div class="app-content1">
    <div class="row mt-30">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <div class="card-title"> Access Role</div>
                </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label">Department</label>

                                    {{Form::select("department_id",$dept,$deptId,["class"=>"form-control  select2-show-search search_dropdown w-100 get-next-child","id"=>"Staff-call_name",'placeholder'=>'Select'])}}

                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label">Designation</label>

                                    {{Form::select("designation_id",$desg,null,["class"=>"form-control  select2-show-search search_dropdown w-100 get-next-child","id"=>"Staff-call_name",'placeholder'=>'Select'])}}

                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label">Staff</label>
                                    {{ Form::hidden('staff_id',$staff_id,["class"=>'_Staff-call_name']) }}
                                    {{Form::select("staff_ids",[],null,["class"=>"form-control select2-show-search search_dropdown w-100 faculty Staff-call_name",'placeholder'=>'Select','Multiple'=>'Multiple'])}}
                                </div>
                            </div>

                        </div>
                    </div>




            </div>
        </div>
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="width: 70%">User Permissions</div>
                    <div class="card-options">
                        <div class="pull-right">
                            <button  class="btn btn-primary saveData">   Save   </button>
                        </div>
                    </div>
                </div>
                {{ Form::model($model,array('url'=>'/accessRole/userRoleBulk', 'method' => 'post','enctype'=>"multipart/form-data",'id'=>'accessRoleForm'))}}
                {{ Form::hidden('staff_id',null,["id"=>"staffIds"]) }}

                {{ Form::hidden('rowIds',$rowIds) }}


                    <div class="card-body p-5">
                        <div class="tab_wrapper first_tab left_side">
                            <ul class="tab_list">
                                @foreach($mainMenu as $menu)
                                    @if($loop->iteration==1)
                                        <li class="active">{{$menu}}</li>
                                    @else
                                        <li>{{$menu}}</li>
                                    @endif
                                @endforeach
                            </ul>

                            <div class="content_wrapper">
                                @foreach($finalArray as $key1=>$menu)

                                <div class="tab_content <?=  ($loop->iteration==1)?'Active':''?>">
                                        <div class="table-responsive">
                                            <table class="table card-table table-vcenter text-nowrap">
                                                <thead >
                                                <tr>
                                                    <th>#</th>
                                                    <th>Sub Menu Name</th>
                                                    <th>Add</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if(sizeof($menu['sub_module'])>1){ ?>
                                                <tr>
                                                    <th></th>
                                                    <th>Check for All</th>
                                                    <td>
                                                        <div class="material-switch">
                                                            <input id="add-<?= $key1 ?>" class="action_add_all" type="checkbox"/>
                                                            <label for="add-<?= $key1 ?>" class="label-primary"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="material-switch">
                                                            <input id="edit-<?= $key1 ?>" class="action_edit_all" type="checkbox"/>
                                                            <label for="edit-<?= $key1 ?>" class="label-primary"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="material-switch">
                                                            <input id="delete-<?= $key1 ?>" class="action_delete_all" type="checkbox"/>
                                                            <label for="delete-<?= $key1 ?>" class="label-primary"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php }?>

                                                @foreach($menu['sub_module'] as $key2=>$subMenu)

                                                <tr>
                                                    <th>{{ $loop->iteration }}</th>
                                                    <td><?= $subMenu['name'] ?></td>
                                                    <td>
                                                        <div class="material-switch">

                                                            <input id="add-<?= $key1 ?>_<?= $key2 ?>" name="module_details[<?= $key1 ?>][<?php echo $key2 ?>][action_add]" <?php if($subMenu['add']) echo 'checked' ?>  class="action_add" type="checkbox"/>
                                                            <label for="add-<?= $key1 ?>_<?= $key2 ?>" class="label-primary"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="material-switch">
                                                            <input id="edit-<?= $key1 ?>_<?= $key2 ?>" name="module_details[<?= $key1 ?>][<?php echo $key2 ?>][action_edit]" <?php if($subMenu['edit']) echo 'checked' ?> class="action_edit" type="checkbox"/>
                                                            <label for="edit-<?= $key1 ?>_<?= $key2 ?>" class="label-primary"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="material-switch">
                                                            <input id="delete-<?= $key1 ?>_<?= $key2 ?>" name="module_details[<?= $key1 ?>][<?php echo $key2 ?>][action_delete]" <?php if($subMenu['delete']) echo 'checked' ?> class="action_delete" type="checkbox"/>
                                                            <label for="delete-<?= $key1 ?>_<?= $key2 ?>" class="label-primary"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                               @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                </div>
                                @endforeach


                            </div>
                        </div>
                    </div>

                {{Form::close()}}
                <div class="card-footer">
                    <div class="clearfix pull-right mb-10">
                       <button class="btn btn-primary saveData">Save</button>
                    </div>
                </div>



            </div>
        </div>


    </div>
</div>


{!! Html::script('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') !!}
{!! Html::script('assets/plugins/tabs/tab-content.js') !!}
<script>
    $('.Staff-call_name').on('change',function () {

       $('#staffIds').val($('.Staff-call_name').val())
    })
    $('.content-area').addClass('container-fluid')
    $('.content-area').removeClass('container')
    $(document).ready(function () {
        var tab_height = ($('.tab_list').height()-1)+"px";
        $('.tab_content').css("min-height",tab_height);
        $('.saveData').click(function () {

            $('#accessRoleForm').submit();
        })







        $('.action_add_all, .action_edit_all, .action_delete_all').click(function () {

            var _addAllChecked = $(this)[0].checked;
            var _addAll = $(this)[0].id;

            for (var i=0; i<$('.action_add').length; i++){
                var str_split = $('.action_add')[i].id;
                str_split = str_split.split('_');
                var _addField = "#"+_addAll+'_'+str_split[1];
                if($(_addField)[0])$(_addField)[0].checked=_addAllChecked;
                //console.log($(_addField)[0].checked);
            }

        })

    });



</script>
@endsection
