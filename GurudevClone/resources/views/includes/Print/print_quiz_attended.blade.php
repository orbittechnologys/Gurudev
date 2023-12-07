@push('includeCss')
    {!! Html::script('js/printThis.js') !!}
    <style>
        #printDiv {
            display: none;
        }

        .amount {
            border-bottom: 1px solid #a5a5a5;
            padding: 5px 12px;
            width: 100%;
        }

        .quantity {
            width: 100%;
            padding: 5px 12px;
        }

        .amt-qty {
            padding: 0 !important;
        }

        #buttons-excel {
            display: none;
        }

    </style>
@endpush
<div class="table-responsive" id="printDiv">
    <table border="1" width="100%" id="collegeinfo">
        <thead>
            <tr>
                <th width="77%" height="35" colspan="7"><img
                    src="{{asset('user/images/logo-dark-text.png')}}"/>
                </th>
            </tr>
            <tr>
                <th width="77%" height="24" colspan="7" align="center" style="color: #756161f7;">
                    <div align="center">
                        <span class="style60">
                            <span class="style60">Quiz Attended Details</span>
                        </span>
                    </div>
                </th>
            </tr>
            <tr>
                <td colspan="3"><b>Title :</b> {{ $detail_list[0]['quiz']['quiz_name'] }}</td>
                <td colspan="3"><b>Type :</b> <?php if($detail_list[0]['quiz']['type']==0){
                                                        echo "Course Wize Quiz";
                                                    }elseif($detail_list[0]['quiz']['type']==1){
                                                        echo "Current Affairs Quiz";
                                                    } else{
                                                        echo "Special Test Quiz";
                                                    }?>
                </td>
            </tr>
            <tr>
                <td colspan="3"><b>Total No Question : </b> {{ $detail_list[0]['quiz']['total_questions'] }}</td>
                <td colspan="3"><b>Total Time : </b> {{ $detail_list[0]['quiz']['total_time'] }}</td>
            </tr>
        </thead>
    </table>
    <table width="100%" id="printTbl">

    </table>
</div>
@push('includeJs')
    @include('includes.CssJs.table-export-btn')
    <script>
        $('body').on('click', '.table-export-btn', function() {
            var btnClass = '.' + $(this).attr('id');
            $(btnClass).click()
        });
        $('body').on('click', '.custom_print', function() {
            $("#printTbl").html($('.quiz_table').html());



            $("#printDiv").printThis({
                importCSS: false,
                importStyle: false,
                loadCSS: ['{{ asset('css/print.css') }}'],
                printContainer: false,
                copyTagClasses: false,
                pageTitle: 'Digital Campus'
            });
        });
    </script>
@endpush
