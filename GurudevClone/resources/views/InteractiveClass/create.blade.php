@extends('layout.adminMain')
@section("title","Live Class")
@include('includes.CssJs.advanced_form')
@section('content')
    <div class="row mt-20">
        <div class="col-lg-1"></div>
        <div class="col-lg-10 col-md-12">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <h3 class="card-title">Create Live Class</h3>
                    <div class="card-options pull-right">
                        <a class="btn btn-primary" href="{{ url('admin/liveClass/list') }}">Live Class List</a>
                    </div>

                </div>
                <div class="card-body">

                    {{Form::model($model,array('url'=>'admin/liveClass/create', 'method' => 'post', 'files' => true,'id'=>'form_id'))}}
                    {{ Form::hidden('id',null) }}
                    <div class="row">
                        <div class=" col-lg-4 ">
                            <div class="form-group">
                                <label class="form-label">Batch<span class="text-danger">*</span></label>
                                {{ Form::select('batch_id',$batch,null,['class'=>'form-control select2-show-search','placeholder'=>'Batch','required']) }}
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                               <label class="form-label">Title / Topic</label>
                                {{ Form::text('title',null,['class'=>'form-control required','placeholder'=>'Title','autocomplete'=>'off','required']) }}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                {{ Form::textarea('description',null,['rows'=>'6','class'=>'form-control required','required']) }}
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="row">
                                <div class="form-group" >
                                    <label class="form-label">When <span class="text-danger"> *</span></label>
                                    <div style="display: flex">
                                        <?php $duration=[]; for($i=1;$i<12;$i++){
                                            $duration[$i.' : 00']=$i.' : 00';
                                            $duration[$i.' : 30']=$i.' : 30';
                                        } ?>
                                        {{ Form::text('class_date',null,['style'=>'width:180px;margin-right: 20px; ','class'=>'form-control fc-datepicker required','placeholder'=>'Date','autocomplete'=>'off','required']) }}
                                        {{ Form::text('start_time',null,['style'=>'width:190px;margin-right: 20px; ','onfocus'=>"(this.type='time')",'class'=>'form-control','autocomplete'=>'off','placeholder'=>'Time','required']) }}
                                        </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Duration <span class="text-danger"> *</span></label>
                                    <div style="display: flex">
                                        <?php $duration=[]; for($i=1;$i<=5;$i++){
                                            $duration[$i]=$i;
                                        } ?>
                                        {{ Form::select('duration_hr',$duration,null,['style'=>'width:100px;margin-right: 20px; ','class'=>'form-control required','autocomplete'=>'off','required']) }}<label style="margin-right: 25px"  class="form-label"> hr</label>
                                        {{ Form::select('duration_min',['00'=>'00','15'=>'15','30'=>'30','45'=>'45'],null,['style'=>'width:100px;margin-right: 20px; ','class'=>'form-control','autocomplete'=>'off','required']) }}<label class="form-label"> min</label>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                {{ Form::select('status',['Active' => 'Active','InActive' => 'In-Active'],null,['class'=>'form-control select2 required','required']) }}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    @include('includes.save_update_button')
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection

@push('includeJs')
    @include('includes.CssJs.advanced_form')
    {{ Html::script("js/dependent_check_out_larvela.js") }}
    @if(!$model)
        <script>
            $('.get-next-child').change();
            var date = new Date();
            var month = date.getMonth()+1;
            var day = date.getDate();
            var today = (day<10 ? '0' : '') + day+'-'+(month<10 ? '0' : '') + month+'-'+date.getFullYear();
            $('.fc-datepicker').val(today)
        </script>
        @else
        <script>
            $('.get-next-child').change();

        </script>
    @endif
@endpush

