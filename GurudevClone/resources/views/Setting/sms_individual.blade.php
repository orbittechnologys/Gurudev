@extends('layout.adminMain')
@section("title","Individual SMS")
@push('includeJs')
    @include('includes.CssJs.dataTable')
    @include('includes.CssJs.advanced_form')
@endpush
@section('content')

    <style>
        .student_container {
            border: 1px solid #e3e3f7;
            border-radius: 5px;
            padding: 10px;
            height: 450px !important;
            background-color: white;
            border-top: 3px solid #605abe;
        }
        .span-input{
            min-width: 50px;
            width: 100px;
            min-height: 30px;
            display: inline-block;
            border-radius: 5px;
            padding: 5px;
            background-color: #d2d2df
        }
        .span-input :before {
    content: "\200D";
    display:inline;
 }
    </style>
    <div class="row  mt-30" id="user-profile">
        <div class="col-lg-12">
            <div class="card" style="min-height: auto">
                <div class="card-header">
                    <div class="card-title">Individual SMS</div>
                    <div class="card-options">
                        <div class="clearfix pull-right d-flex">
                            <a href="{{ url('smsTemplate') }}" class="mr-2 btn btn-instagram wrap">Add SMS Template</a>
                        </div>
                        <div class="clearfix pull-right d-flex">
                            <a href="{{ url('sms_list') }}" class="mr-2 btn btn-facebook wrap" id="classWiseSmsBtn">SMS List</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row  mt-10 mb-30" id="user-profile">
                <div class="col-lg-6">
                    <div class="student_container vscroll h-400  pr-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User Name</th>
                                    <th>Mobile Number</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($user_list as $list)
                                <tr class="student_row">
                                    <td><input type="checkbox" name="user_id" class="user_id" value="{{ $list['id'] }}"></td>
                                    <td>{{ $list['name']}}</td>
                                    <td>{{ $list['mobile'] }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>SMS Templates</label>
                                        {{ Form::select('templates',$templates,null,['class'=>'select2-show-search required template','required',"placeholder"=>"Templates"])}}

                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Message</label><span class="text-danger"> (White spaces are not allowed)</span>
                                        <div id="message" class="form-control" style="height: 100px"></div>
                                        <span class="text-danger message"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class=" pull-right">
                                        <button type="button" class="save_data btn btn-success">Send Message</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

{{--------------------------------- Slim Scrool --------------------------------------}}
    {{ Html::style("assets/plugins/jquery.mCustomScrollbar/jquery.mCustomScrollbar.css") }}

    {{ Html::script("assets/plugins/jquery.mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js") }}
    {{ Html::script("assets/plugins/jquery.mCustomScrollbar/jquery.mCustomScrollbar.js") }}




    <script>
        $('.user_id').click(function () {
            if($(this).prop('checked')){
                $(this).prop('checked', false);
            }else {
                $(this).prop('checked', true);
            }
        });

        $('.student_row').click(function () {
            var $_this = $(this).find('.user_id').prop('checked');
            if($_this){
                $(this).find('.user_id').prop('checked',false);
            }else {
                $(this).find('.user_id').prop('checked',true);
            }
        });


        $('.save_data').click(function () {
            var selected_data = $('.user_id:checked').parents('tr');
            var data = [[]];
            var template=$(".template option:selected" ).text();

            if($(selected_data).length==0){
                alert('select Users')
                return
            }else if(template==''){
                alert('Please select SMS Template')
                return
            }else if($('#message').text()==''){
                $('.message').text('Message was not be Empty..!');
            }else{
                for(var i=0; i<$(selected_data).length; i++){
                    var user_id = $($(selected_data)[i]).find('.user_id').val();
                    var name = $($($(selected_data)[i]).find('td')[1]).html();
                    var mobile = $($($(selected_data)[i]).find('td')[2]).html();

                    var date = "<?php echo date('Y-m-d'); ?>" ;
                    var item = {
                        user_id:user_id,
                        mobile:mobile,
                        template:template,
                        date:date,
                        sms_type:'individual',
                        message:$('#message').text()
                    };
                    data[i]=item;
                }
                    console.log(item)
                smsSend(data);
            }
        });

        function smsSend(data){
            $.ajax({
                type: 'POST',
                data: {"_token": "{{ csrf_token() }}", data:data},
                url:"{{ url('\sms_individual') }}",
                cache: false,
                success: function(data) {
                    var message,type;
                    if(data == 'success'){
                        message="Message Sent Successfully..!";
                         type= 'success';
                    }else{
                        message="Massage Not Sent. Try Again..!";
                        type= 'warning';
                    }

                    swal({
                            title: "",
                            text: message,
                            type: type,
                            html:true,
                            showCancelButton: false,
                            confirmButtonColor: '#DD6B55',
                            confirmButtonText: 'Ok',

                            closeOnConfirm: false,
                            closeOnCancel: true
                        },
                        function(isConfirm){

                            if (isConfirm) {
                                window.location.href = "{{ url('\sms_list') }}";
                            }
                    });
                },
                error:function (data) {
                    console.log(data)

                }

            });
        }

        $('.template').on('change',function(){
            let template=$(this).val()
            for(i=1;i<10;i++)
                template=template.replace('input'+i, 'input');
            templateArr=template.split('input')
            mesg='';
            for(i=0;i<templateArr.length;i++){
                mesg+=templateArr[i];
                if((i+1)!=templateArr.length)
                mesg+=`<span contenteditable class="span-input"></span>`

            }
            $('#message').html(mesg)

        })

    </script>
    <div class='notify-alert alert alert-success col-xl-3 col-lg-3 col-md-3 col-12 animated fadeInDown' id='ajax-alert'></div>
@endsection
