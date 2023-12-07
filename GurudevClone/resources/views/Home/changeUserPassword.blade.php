@extends('layout.userMain')
@section('title','Change Password')
@section("content")
    <!-- Main content -->
    @php($backUrl='dashboard')
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="page-title">Change Password</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i
                                            class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Change Password</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        {{ Form::open(array('url' => '/resetUserPassword' ,'method'=>'POST','id'=>'forget_pwd_form')) }}
        <div class="row">
            <div class="col-lg-4 col-md-6 col-12 offset-lg-4 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title"><h5>Change Password</h5></div>
                    </div>

                    <div class="card-body bt btr-0">
                        <div class="form-group mb-3">
                            <label>Current Password</label>
                            <div class="input-group ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text  bg-transparent"><i class="ti-lock"></i></span>
                                </div>
                                <input name="current_password" type="password" class="form-control pl-15 bg-transparent pwd pwd-password1 required" placeholder="Current Password" required>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label>New Password</label>
                            <div class="input-group ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text  bg-transparent"><i class="ti-lock"></i></span>
                                </div>
                                <input name="password" type="password" class="form-control pl-15 bg-transparent pwd pwd-password1 required" placeholder="New Password" required>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label>Confirm Password</label>
                            <div class="input-group ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text  bg-transparent"><i class="ti-lock"></i></span>
                                </div>
                                <input name="password_confirmation" type="password" class="form-control pl-15 bg-transparent pwd pwd-password2 required" required placeholder="Confirm Password">
                            </div>
                            <span class="password-error text-danger"> </span>
                        </div>
                       
                        @foreach($errors->all() as $item)
                        <div class="row">
                            <div class="col-lg-12">
                                <p class="text-danger">{{$item}}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="card-footer float-right">

                        <button type="submit" class=" btn-sm waves-effect waves-light btn btn-danger  float-right"><i
                                    class="fa fa-lock"></i> Change password</button>

                    </div>
                    {{--  --}}
                </div>
            </div>
        </div>
        {{ Form::close()}}
    </section>
@endsection
@push('includeJs')
@endpush