$(function(){
    $('.required').prev().append( ' <span class="text-danger"> *</span>');

           $.fn.showAlert=function(alert,message){
            alert='alert-'+alert;
            $("#php-alert").addClass(alert)
            $('.alert-message').html(message)
            $("#php-alert").css('display','block');
            $("#php-alert").fadeOut(2000,function(){
                $("#php-alert").removeClass(alert);
            })
        }
        
        
        /*//////////////////// Delete before confirm //////////////////////*/
    $('.confirm-delete').on('click', function () {
        if(!confirm('Are you sure you want to delete this record ?'))
            event.preventDefault();
    });
    $('.announcementReadMore').on('click',function () {
        let data=$(this).attr('data-content')


    })

    $('.match-height').each(function(){

        // Cache the highest
        var highestBox = 0;

        // Select and loop the elements you want to equalise
        $('.column', this).each(function(){

            // If this box is higher than the cached highest then store it
            if($(this).height() > highestBox) {
                highestBox = $(this).height();
            }

        });

        // Set the height of all those children to whichever was highest
        $('.column',this).height(highestBox);


    });

})
