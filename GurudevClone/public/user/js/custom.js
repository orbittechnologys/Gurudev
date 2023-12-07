$(function(){

    $('.announcementReadMore').on('click',function () {
        let data=JSON.parse($(this).attr('data-content'))
        $('.announcement-title').html(data.title);
        $('.announcement-body').html(data.description);
        $('.announcement-date').html(data.date);
        $('.announcement-attachment').hide();
        $('.announcement-pdf').hide();
        $('.announcement-url').hide();
        if(data.attachment!='' && data.attachment!=null) {
            $('.announcement-attachment').attr('href',data.attachment);
            $('.announcement-attachment').show();
        }
        if(data.pdf!='' && data.pdf!=null) {
            $('.announcement-pdf').attr('href',data.pdf);
            $('.announcement-pdf').show();
        }
        if(data.url!='' && data.url!=null) {
            $('.announcement-url').attr('href',data.url);
            $('.announcement-url').show();
        }
        $('#modal-announcement').modal('show')
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
