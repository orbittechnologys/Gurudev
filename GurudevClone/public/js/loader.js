JqeryLoader = {
    show: function() {
        $('#ajxloader').css('display','block');
    },
    hide: function() {
        $('#ajxloader').css('display','none');

    }
}

$(document).ajaxStart(function() {
    $('#dynamic_table_list_processing').attr('style', 'opacity: 0 !important');
    JqeryLoader.show();
}).ajaxStop(function() {
    JqeryLoader.hide();
}).ajaxError(function(a, b, e) {
    $('#ajxloader').css('width','20%');
    throw e;
});
