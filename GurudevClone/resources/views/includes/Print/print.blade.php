@push('includeCss')
    {!! Html::script('js/printThis.js') !!}
    <style>
        #printDiv{
            display: none;
        }
        .amount{
            border-bottom: 1px solid #a5a5a5;
            padding: 5px 12px;
            width: 100%;
        }
        .quantity{
            width: 100%;
            padding: 5px 12px;
        }
        .amt-qty{
            padding: 0!important;
        }
    </style>
@endpush
<div class="table-responsive" id="printDiv">
    <table border="1" width="100%" id="collegeinfo">
        <thead>
        <tr>
            <th width="77%" height="25" colspan="7">
                <h4><strong>Gurudev Academy IAS & KAS Academy </strong></h4>
            </th>
        </tr>
        <tr>
            <th width="77%" height="24" colspan="7" align="center" style="color: #756161f7;">
                <div align="center">
                    <span class="style60">
                        <span class="style60">@yield('title')</span>
                    </span>
                </div>
            </th>
        </tr>
        </thead>
    </table>
    <table width="100%">

    </table>
    <table width="100%" id="printTbl">
        <style>
            .amount{
                border-bottom: 0.5px solid #54505a;
                padding: 5px 12px;
                width: 100%;
            }
            .quantity{
                width: 100%;
                padding: 5px 12px;
            }
            .amt-qty{
                overflow: hidden;
                padding: 0!important;
            }
        </style>
        <thead>
        <tr>

        </tr>
        <tr>

        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
@push('includeJs')
    @include('includes.CssJs.table-export-btn')
    <script>
        $('body').on('click','.table-export-btn',function (){
            var btnClass='.'+$(this).attr('id');
            $(btnClass).click()
        });
        $('body').on('click','.custom_print',function () {
            $("#printTbl tbody").empty();
            $("#printTbl>thead>tr:eq(0)").empty();
            var actionClmnIndex; var rowValue=0;
            $('#dynamic_table_list thead tr:eq(0) th').each(function (i) {
                if($(this).html()=='Action'){
                    actionClmnIndex=i;
                }
                var value=0;

                //Check if it is a Textbox
                if ($(this).find("input").filter(function() {
                    return this.type === "text";
                }).length) {
                    if($(this).find('input').val()!=''){
                        $("#printTbl>thead>tr:eq(0)").append("<th>"+$(this).find('input').val()+"</th>");
                        value=1;rowValue++;
                    }
                }
                else{
                    //Check if it is a Select
                    if($(this).has("select")){
                        if($(this).find('select').find('option:selected').val()!=undefined && $(this).find('select').find('option:selected').val()!=''){
                            $("#printTbl>thead>tr:eq(0)").append("<th>"+$(this).find('select').find('option:selected').text()+"</th>");
                            value=1;rowValue++
                        }
                    }
                }

                if(value==0){
                    $("#printTbl>thead>tr:eq(0)").append("<th></th>");
                }
            });
            $("#dynamic_table_list tbody").clone().appendTo("#printTbl");

            actualCount=$("#printTbl > thead>tr:eq(1) > th").length;
            absoluteCount=$("#printTbl > thead>tr:eq(0) > th").length;

            if(actualCount!=absoluteCount){
                $("#printTbl > thead>tr:eq(0) > th:eq("+actionClmnIndex+")").remove();
                actionClmnIndex=actionClmnIndex+1;
                $("#printTbl > tbody>tr > td:nth-child("+actionClmnIndex+")").remove();
            }

            $("#printTbl > thead>tr:eq(0) > th").css("background-color",'#66ccff');

            $("#printTbl > thead>tr:eq(0)").show();
            if(rowValue==0)
                $("#printTbl > thead>tr:eq(0)").hide();


            $("#printDiv").printThis({
                importCSS: false,
                importStyle:false,
                loadCSS:['{{ asset('css/print.css') }}'],
                printContainer: false,
                copyTagClasses: false,
                pageTitle:'Digital Campus'
            });
        });
    </script>
@endpush
