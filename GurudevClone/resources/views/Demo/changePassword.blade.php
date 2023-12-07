@extends('layout.userMain')

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
        {{ Form::open(array('url' => '/change-password' ,'method'=>'POST','id'=>'forget_pwd_form')) }}
        <div class="row">
            <div class="col-lg-4 col-md-4 col-12"></div>
            <div class="col-lg-5 col-md-5 col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title"><h5>Change Password</h5></div>
                    </div>

                    <div class="card-body bt btr-0">
                        <div class="form-group mb-3">
                            <div class="input-group ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent"><i class="ti-lock"></i></span>
                                </div>
                                <input type="text" class="form-control pl-15 bg-transparent old-pwd"  required placeholder="Old Password">
                            </div>
                            <span class="oldPwdMesg text-danger"> </span>
                        </div>
                        <div class="form-group mb-3">
                            <div class="input-group ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text  bg-transparent"><i class="ti-lock"></i></span>
                                </div>
                                <input type="text" class="form-control pl-15 bg-transparent pwd pwd-password1" readonly placeholder="New Password">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="input-group ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text  bg-transparent"><i class="ti-lock"></i></span>
                                </div>
                                <input type="text" class="form-control pl-15 bg-transparent pwd pwd-password2" readonly required
                                       placeholder="Confirm Password">
                            </div>
                            <span class="password-error text-danger"> </span>
                        </div>
                    </div>
                    <div class="card-footer float-right">

                        <button type="submit" class=" btn-sm waves-effect waves-light btn btn-danger  float-right"><i
                                    class="fa fa-lock"></i> Change password</button>

                    </div>
                </div>
            </div>

        </div>
        {{ Form::close()}}
    </section>
@endsection
@push('includeJs')
    <script>
        var pwdsubmit=0
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
        $('.old-pwd').on('input',function () {

            checkOldPassword();
        })
        function checkOldPassword() {
            let oldPassword='{{Auth::user()->password}}'
            let oldInputPwd=$('.old-pwd').val()

            if(oldInputPwd.length>=oldPassword.length){
                if(oldInputPwd!==oldPassword){
                    $('.pwd').val('').attr('readonly')
                    $('.oldPwdMesg').html('Incorrect Old Password')

                }
                else{
                    $('.pwd').removeAttr('readonly')
                    $('.oldPwdMesg').html('')
                    $('.pwd-password1').focus()
                }
            }


        }
    </script>
@endpush