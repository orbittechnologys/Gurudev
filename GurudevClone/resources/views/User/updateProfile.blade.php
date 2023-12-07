@extends('layout.userMain')
@section('title','Profile')
@section("content")
    <!-- Main content -->
    @php($backUrl='dashboard')
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="page-title">Profile</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i
                                            class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        {{ Form::model($model,array('url'=>'/updateProfile','method' => 'post', 'files' => true))}}
        {{ Form::hidden('id',null) }}
        {{ Form::hidden('profile',null) }}
        <div class="row">
            <div class="col-lg-2 col-md-2 col-12"></div>
            <div class="col-lg-8 col-md-8 col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title"><h5>Update Profile</h5></div>
                    </div>

                    <div class="card-body bt btr-0">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Full Name</label>
                                    {{ Form::text('name',null,['class'=>'form-control required','placeholder'=>'Full Name','required']) }}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Profile</label>

                                    {{ Form::file('new_profile',['class'=>'form-control image_type profile_image','accept'=>'image/*',]) }}
                                    @if($model['profile']!='')
                                        <a class="text-danger"  href="{{uploads($model['profile'])}}" target="_blank">Uploaded</a>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Mobile</label>
                                    {{ Form::text('mobile',null,['class'=>'form-control required','placeholder'=>'Mobile','required']) }}
                                </div>
                                @error('mobile')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    {{ Form::email('email',null,['class'=>'form-control required','placeholder'=>'Email','required']) }}
                                </div>
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>City</label>
                                    {{ Form::text('city',null,['class'=>'form-control ','placeholder'=>'City']) }}
                                </div>
                                @error('city')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Zipcode</label>
                                    {{ Form::text('zipcode',null,['class'=>'form-control ','placeholder'=>'Zipcode']) }}
                                </div>
                                @error('zipcode')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer float-right">

                        <button type="submit" class=" btn-sm waves-effect waves-light btn btn-danger  float-right"><i
                                    class="fa fa-save"></i> Update Profile
                        </button>

                    </div>
                </div>
            </div>

        </div>
        {{ Form::close()}}
    </section>
@endsection
@push('includeJs')
    {!! Html::script("js/check_file_type.js" )!!}
    <script>
        var pwdsubmit = 0
        $('#forget_pwd_form').submit(function (event) {

            if (pwdsubmit == 0) {
                event.preventDefault();
                checkOldPassword();

                var pass = $('.pwd-password1').val();
                var con_pass = $('.pwd-password2').val();
                if (pass === con_pass && pass !== '') {
                    if (pass.length < 8) {
                        $('.password-error').html('Password must contain 8 characters !!!');
                        return
                    }

                    pwdsubmit = 1;
                    $('#forget_pwd_form').submit();

                } else {
                    $('.password-error').html('Confirm Password not Matched !!!');
                }
            }
        });
        $('.old-pwd').on('input', function () {

            checkOldPassword();
        })

        function checkOldPassword() {
            let oldPassword = '{{Auth::user()->password}}'
            let oldInputPwd = $('.old-pwd').val()

            if (oldInputPwd.length >= oldPassword.length) {
                if (oldInputPwd !== oldPassword) {
                    $('.pwd').val('')
                    $('.pwd').attr('readonly')
                    $('.oldPwdMesg').html('Incorrect Old Password')

                } else {
                    $('.pwd').removeAttr('readonly')
                    $('.oldPwdMesg').html('')
                    $('.pwd-password1').focus()
                }
            }


        }
    </script>
@endpush
