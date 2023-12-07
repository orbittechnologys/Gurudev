@extends('layout.adminMain')
@section("title","Main Menu")
@section('pagespecificstyle')
    @include('includes.CssJs.dataTable')
    @include('includes.CssJs.advanced_form')
@endsection
@section("content")
    <style>
        .card
        {
            border-top: 2px solid #005bea;
        }
    </style>
    <div class="row mt-50">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title"> Sub Menu</div>
                </div>
                {{ Form::model($get_sme,array('url'=>'accessRole/subMenu','type'=>'post')) }}
                {{ Form::hidden('id',null) }}
                <div class="card-body ">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label">Main Menu</label>
                                {{ Form::select('module_detail_id',$mainmenu,null,array('label'=>false,'class'=>'form-control get-next-child select2','placeholder'=>'Main Menu','required','id'=>'SubModule-sub_module_name-1')) }}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label">Level</label>
                                {{ Form::select('level',['Level1'=>'Level 1','Level2'=>'Level 2'],null,array('label'=>false,'class'=>'form-control select2','required','id'=>'level')) }}
                            </div>
                        </div>
                        <div class="col-lg-12" id="sub_under">
                            <div class="form-group">
                                <label class="control-label">Under</label>
                                    {{ Form::hidden('under',null,array('class'=>'_SubModule-sub_module_name-1'))}}
                                    {{ Form::select('under',[],null,array('label'=>false,'class'=>'form-control SubModule-sub_module_name-1 select2'))}}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label">Sub Menu</label>
                                {{ Form::text('sub_module_name',null,array('label'=>false,'class'=>'form-control','placeholder'=>'Sub Menu','required')) }}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label">Url</label>
                                {{ Form::text('url',null,array('label'=>false,'class'=>'form-control','placeholder'=>'Url')) }}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label">Position</label>
                                {{ Form::text('position',null,array('label'=>false,'class'=>'form-control isNumber','placeholder'=>'Position','required')) }}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <?php
                            $chkstyley = "Checked";
                            $chkstylen = "";
                            if(!empty($get_sme))
                            {
                                if($get_sme->is_default == 0)
                                {
                                    $chkstylen = "Checked";
                                    $chkstyley = "";
                                }
                            }
                            ?>
                            <!--<label for="chkme" class="form-check-label fs-16">
                                Is Default &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                {{ Form::checkbox('is_default',null,$chkstyle,array('label'=>false,'class'=>'form-check-input','id'=>'chkme')) }}
                            </label>-->
                            <div class="form-radio">
                                <div class="radio radio-inline fs-15">
                                    Is Default &nbsp;&nbsp;
                                    <label>&nbsp;&nbsp;&nbsp;
                                        {{ Form::radio('is_default','1',$chkstyley,array('label'=>false,'class'=>'form-check-input')) }}
                                        <i class="helper"></i>Yes &nbsp;&nbsp;
                                    </label>
                                    <label>&nbsp;&nbsp;&nbsp;
                                        {{ Form::radio('is_default','0',$chkstyle,array('label'=>false,'class'=>'form-check-input')) }}
                                        <i class="helper"></i>No
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <button type="submit" class="btn btn-primary pull-right mb-10" >Save</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Sub Menu List</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover text-nowrap table-striped table-bordered text-nowrap w-100" id="example">
                            <thead class="bg-blue">
                                <tr class="hidden-row">
                                    <td>#</td>
                                    <td>Main Menu</td>
                                    <td>Sub Menu</td>
                                    <td>Level</td>
                                    <td>Under</td>
                                    <td>Url</td>
                                    <td>Position</td>
                                    <td>Is Default</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i =1;
                                foreach($get_sm as $get_list){
                                    if(empty($get_sme))
                                    {
                                        $eurl = "subMenuEdit/".$get_list->id ;
                                        $durl = "subMenuDelete/".$get_list->id;
                                    }
                                    else
                                    {
                                        $eurl = "../subMenuEdit/".$get_list->id ;
                                        $durl = "../subMenuDelete/".$get_list->id ;
                                    }
                                    ?>
                                <tr>
                                    <td>{{ $i }} </td>
                                    <td>{{ $get_list->MainMenu->module_name  }} </td>
                                    <td>{{ $get_list->sub_module_name }} </td>
                                    <td>{{ $get_list->level }} </td>
                                    <td>{{ $get_list->SubMenuUnder->sub_module_name }} </td>
                                    <td>{{ $get_list->url }} </td>
                                    <td>{{ $get_list->position  }} </td>
                                    <td>
                                        @if($get_list->is_default == '1')
                                            Yes
                                        @else
                                            No
                                        @endif
                                    </td>
                                    <td>
                                        <a href="<?php echo $eurl;?>" class="table_icons" data-toggle="tooltip" data-original-title="Edit" ><i class="ti ti-pencil text-primary" aria-hidden="true"></i></a>|
                                        <a href="<?php echo $durl;?>"  class="table_icons" data-toggle="tooltip" data-original-title="Delete" ><i class="ti ti-trash text-danger" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                                <?php $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    $('#level').on('change', function() {
        var level = $( "#level" ).val();
        if(level == 'Level1'){
            $('#sub_under').hide();
        }
        else{
            $('#sub_under').show();
        }
    });
</script>
@endsection
