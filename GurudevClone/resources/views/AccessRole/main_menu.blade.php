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
                <div class="card-title"> Main Menu</div>
            </div>
            {{ Form::model($getmm_edata,array('url'=>'accessRole/mainMenu','type'=>'post')) }}
            {{ Form::hidden('id',null) }}
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                             <label class="control-label">Name</label>
                             {{ Form::text('module_name',null,array('label'=>false,'class'=>'form-control','placeholder'=>'Name','required')) }}
                         </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="control-label">Icon Name <span class="text-danger"> (Only Simple Line Icon Allowed) </span></label>
                            {{ Form::text('icon_name',null,array('label'=>false,'class'=>'form-control','placeholder'=>'Icon Name','required')) }}
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="control-label">Position</label>
                            {{ Form::text('position',null,array('label'=>false,'class'=>'form-control isNumber','placeholder'=>'Position','required')) }}
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="control-label">Status</label>
                        `   {{Form::select("status",['Active'=>'Active','Inactive'=>'Inactive'],null,["class"=>"form-control select2 priority",'required'])}}
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
                <div class="card-title">Main Menu List</div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-hover text-nowrap table-striped table-bordered text-nowrap w-100">
                        <thead class="bg-blue">
                            <tr class="hidden-row">
                                <td>#</td>
                                <td>Main Menu</td>
                                <td>Status</td>
                                <td>Position</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1;
                            foreach($getmm_data as $getmm_list)
                            {
                                if(empty($getmm_edata))
                                {
                                    $eurl = "mainMenuEdit/".$getmm_list->id ;
                                    $durl = "mainMenuDelete/".$getmm_list->id;
                                }
                                else
                                {
                                    $eurl = "../mainMenuEdit/".$getmm_list->id ;
                                    $durl = "../mainMenuDelete/".$getmm_list->id ;
                                }
                                ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td><i class="{{ $getmm_list->icon_name }}"> </i>  {{ $getmm_list->module_name }}</td>
                                    <td>{{ $getmm_list->status }}</td>
                                    <td>{{ $getmm_list->position }}</td>
                                    <td>
                                        <a href="<?php echo $eurl;?>" class="table_icons" data-toggle="tooltip" data-original-title="Edit" ><i class="ti ti-pencil text-primary" aria-hidden="true"></i></a>|
                                        <a href="<?php echo $durl;?>"  class="table_icons" data-toggle="tooltip" data-original-title="Delete" ><i class="ti ti-trash text-danger" aria-hidden="true"></i></a>
                                    </td>
                                </tr> <?php $i++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
