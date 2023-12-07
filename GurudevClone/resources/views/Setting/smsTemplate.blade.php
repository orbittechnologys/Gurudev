@extends('layout.adminMain')
@section("title","SMS Template")
@section('content')
    <div class="row mt-30">
        <div class="col-md-4">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <h3 class="card-title">SMS Template</h3>
                    <div class="card-options">
                        <div class="clearfix pull-right d-flex">
                            <a href="{{ url('sms_list') }}" class="mr-2 btn btn-facebook wrap" id="classWiseSmsBtn">SMS List</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    {{ Form::model($model,array('url'=>'/smsTemplate', 'method' => 'post', 'files' => true))}}
                    {{ Form::hidden('id',null) }}

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Title</label>
                                {{ Form::text('title',null,['class'=>'form-control required','placeholder'=>'Title','required']) }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Sender</label>
                                {{ Form::text('sender',null,['class'=>'form-control required','placeholder'=>'Sender','required']) }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Template <br/> <span class="text-danger"><b>Note: </b>1.Please Use TextLocal's Approved Templates</span><br/>
                                    <span class="text-danger"><b>Note: </b>2. Please use the template as in TextLocal</span>
                                </label>
                                {{ Form::textarea('template',null,['rows'=>'6','class'=>'form-control','placeholder'=>'Template','required']) }}
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
        <div class="col-md-8">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <h3 class="card-title">SMS Template</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table  id="current_affairs" class="table table-striped table-bordered w-100">
                            <thead class="bg-blue">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Template</th>
                                <th>Sender</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($table_list['data'] as $array)
                                <tr>
                                    <td>{{$loop->iteration }}</td>
                                    <td> {{ $array['title'] }}    </td>
                                    <td> {{ $array['template'] }}    </td>
                                    <td> {{ $array['sender'] }}    </td>
                                    <td class="text-nowrap">

                                        <a href="{{ route('smsTemplate',['id'=>$array['id']])}}" class="table_icons" data-toggle="tooltip" data-original-title="Edit"><i class="ti ti-pencil" aria-hidden="true"></i></a>
                                        <a href="{{ route('dynamicDelete',['modal'=>'SmsTemplate','id'=>$array['id']]) }}" class="table_icons confirm-delete" data-toggle="tooltip" data-original-title="Delete" ><i class="ti ti-trash" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('includeJs')
    @include('includes.CssJs.advanced_form')
    @include('includes.CssJs.dataTable')

@endpush
