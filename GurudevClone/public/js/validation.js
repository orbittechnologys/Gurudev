// Number Validation
function isNumber(evt,field) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode==46){
        return true;

    }

    if (charCode > 31 && (charCode < 48 || charCode > 57 ) ) {
        $(field).attr("placeholder", "Please Enter Only Numbers");
        return false;
    }
    return true;
}
$('body').on('keypress change','.mobileNo',function(e){

    $(this).attr({
        'pattern': '[6-9]{1}[0-9]{9}',
        'title' : "Enter 10 Digit Number.."
    });
    var mob=$(this).val();
    if(mob.length>9){
        $('<p  style="position: absolute; left: 30px;"  class="text-danger error-class">10 Digits Only</p>').insertAfter(this).fadeOut("slow", function(){ $(".error-class").remove();});
        return false;
    }

    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        $('<p  style="position: absolute; left: 30px;"  class="text-danger error-class">Digits Only</p>').insertAfter(this).fadeOut("slow", function(){ $(".error-class").remove();});
        return false;
    }
});
$('body').on('keypress','.isNumber',function(e){

    var field=$(this);
    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        $(this).addClass("mb-20")
        $('<p  style="position: absolute; margin-top:-20px"  class="text-danger error-class">Digits Only</p>').insertAfter(this).fadeOut("slow", function(){  $(field).removeClass("mb-20"); $(this).css("margin-bottom","0px"); $(".error-class").remove();   });
        return false;
    }
});
$('body').on('keypress','.switch',function(e){

    var field=$(this);
    //if the letter is not digit then display error and don't type anything
    if (e.which != 48 && e.which !=49) {
        $(this).addClass("mb-20")
        $('<p  style="position: absolute; margin-top:-20px"  class="text-danger error-class">Invalid Value</p>').insertAfter(this).fadeOut("slow", function(){  $(field).removeClass("mb-20"); $(this).css("margin-bottom","0px"); $(".error-class").remove();   });
        return false;
    }

    if(field.val().length>0){
        $(this).addClass("mb-20")
        $('<p  style="position: absolute; margin-top:-20px"  class="text-danger error-class">1 Digit Only</p>').insertAfter(this).fadeOut("slow", function(){  $(field).removeClass("mb-20"); $(this).css("margin-bottom","0px"); $(".error-class").remove();   });
        return false;
    }
});
$(document).ready(function() {
        var options = {};
    options.ranges = {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],

        'This Month': [moment().startOf('month'), moment().endOf('month')],

        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        'Last 3 Month': [moment().subtract(3, 'month').startOf('month'), moment().endOf('month')],
        'Last 6 Month': [moment().subtract(6, 'month').startOf('month'), moment().endOf('month')],
        'This Year': [moment().startOf('year'), moment().endOf('month')],
        'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().endOf('month')]

    };
    options.linkedCalendars = false;
    options.startDate= moment().startOf('year'),
    options.endDate= moment().endOf('year'),
    options.locale = {
        format: 'DD-MM-YYYY',
        separator: ' - ',
        applyLabel: 'Apply',
        cancelLabel: 'Cancel',
        fromLabel: 'From',
        toLabel: 'To',
        customRangeLabel: 'Custom',
        daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
        monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        firstDay: 1
    };
    $(".dateRangePickerInput").daterangepicker(options, function(start, end, label) {




    });
});
