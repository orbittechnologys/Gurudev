@extends('layout.adminMain')
@section('title','Change Password')
@section('additionalHeaderAssets')
    <style>
        .form-control[readonly] {
            background-color: #66666b26  !important;
            opacity: 1;
        }
    </style>
    @endsection
@section('content')
    <div class="container">
        <div class="row mt-30">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="card overflow-hidden">
                    <div class="card-header">
                        <h3 class="card-title">Change Password</h3>
                    </div>
                    <div class="card-body">
                        <div class="hidden validate_user" style="display: none;">{{ $password}}</div>
                        {{ Form::open(array('url' => '/admin/changePassword' ,'method'=>'POST','id'=>'change_password_form')) }}
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group mb-30">
                                    <label>Old Password:</label>
                                    {{ Form::password('old_password',array('class' => 'form-control login-input-field','id'=>'old_password','placeholder'=>'Old Password','required')) }}
                                    <span class="text-danger old_password_error"></span>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group mb-30">
                                    <label>New Password:</label>
                                    {{ Form::password('new_password',array('class' => 'form-control login-input-field', 'id'=>'new_password', 'readonly', 'placeholder'=>'New Password','required')) }}
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group mb-30">
                                    <label>Confirm Password:</label>
                                    {{ Form::password('confirm_password',array('class' => 'form-control login-input-field','id'=>'confirm_password','readonly','placeholder'=>'Confirm Password','required')) }}
                                    <span class="text-danger confirm_password_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="col-sm-12">
                            <div class="form-group text-center">
                                <button type="submit"  class="btn btn-colored btn-xl btn-info btn-block mb-10 login-button">Change Password</button>
                                @if ($error = $errors->first('password'))
                                    <div class="text-danger text-center">
                                        {{ $error }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    <script>
    $('#old_password').on('keyup',function () {
        $("#new_password").attr("readonly", "readonly");
        $("#new_password").val("");
        $("#confirm_password").attr("readonly", "readonly");
        $("#confirm_password").val("");

        $('.old_password_error').html('')
        old_password=$(this).val();
        validate_user=$('.validate_user').html();
        if(old_password.length>=validate_user.length){
            if(old_password!=validate_user){
                $('.old_password_error').html('Invalid Old Password')
                $(this).focus()
            }
            else{
                $("#new_password").removeAttr("readonly");
                $("#confirm_password").removeAttr("readonly");
            }
        }
    })
    $('#confirm_password').on('keyup',function () {

        $('.confirm_password_error').html('')
        confirm_password=$(this).val();
        new_password=$('#new_password').val();
        if(confirm_password.length>=new_password.length){
            if(confirm_password!=new_password){
                $('.confirm_password_error').html('Password does not Match')
                $(this).focus()
            }

        }
    })
        $('#change_password_form').on('submit',function (e) {

            confirm_password=$('#confirm_password').val();
            new_password=$('#new_password').val();
            if(confirm_password.length>7){
                if(confirm_password!=new_password) {
                    e.preventDefault()
                    $('#confirm_password').focus()
                    $('.confirm_password_error').html('Password does not Match')
                }
            }
            else{
                e.preventDefault()
                $('#confirm_password').focus()
                $('.confirm_password_error').html('A Password must contain atlist  8 characters')
            }

        })
    </script>
@endsection
