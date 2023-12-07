(function($) {
    $.fn.checkFileType = function(options) {
        var defaults = {
            allowedExtensions: [],
            success: function() {},
            error: function() {}
        };
        options = $.extend(defaults, options);

        return this.each(function() {

            $(this).on('change', function() {
                var value = $(this).val(),
                    file = value.toLowerCase(),
                    extension = file.substring(file.lastIndexOf('.') + 1);

                if ($.inArray(extension, options.allowedExtensions) == -1) {
                    options.error();
                    $(this).focus();
                    $(this).val(null)
                } else {
                    options.success();

                }

            });

        });
    };

})(jQuery);

$(function() {
    $('.image_type').checkFileType({
        allowedExtensions: ['jpg','JPG','JPEG', 'jpeg','png','PNG'],
        success: function() {
            $('.invalid_file').remove();
        },
        error: function() {
            $('.invalid_file').remove();
            $('.image_type').after("<span class='text-danger text-bold invalid_file'>Invalid Image Type only (jpg,jpeg,png) images are supported..</span>");
        }
    });
    $('.stud_doc').checkFileType({

        allowedExtensions: ['jpg','JPG','JPEG', 'jpeg','png','PNG','pdf','PDF',],
        success: function() {
            $('.invalid_file').remove();
        },
        error: function() {
            $('.invalid_file').remove();
           alert('Invalid File Type only (jpg,jpeg,png,pdf) file are supported..')
        }
    });
    $('.doc_type').checkFileType({
        allowedExtensions: ['pdf','PDF'],
        success: function() {
            $('.invalid_file').remove();
        },
        error: function() {
            $('.invalid_file').remove();
            $('.doc_type').after("<span class='text-danger text-bold invalid_file'>Invalid File Type only (pdf,doc,docx,pptx) files are supported..</span>");
        }
    });

    $('.video_type').checkFileType({
        allowedExtensions: ['MP4','mp4'],
        success: function() {
            $('.invalid_file').remove();
        },
        error: function() {
            $('.invalid_file').remove();
            $('.video_type').after("<span class='text-danger text-bold invalid_file'>Only Mp4 file types are allowed..</span>");
        }
    });
    $('.video_type').bind('change', function() {

        //this.files[0].size gets the size of your file.
        console.log(this.files[0])
        var file_size = this.files[0].size; //in byts;
        if (file_size > 500000000) {
            alert('File Size Must be less than 500 MB');
            $(this).val('');
        }

    });
    $('.stud_doc').bind('change', function() {

        //this.files[0].size gets the size of your file.
        console.log(this.files[0])
        var file_size = this.files[0].size; //in byts;
        if (file_size > 10000000) {
            alert('File Size Must be less than 10 MB');
            $(this).val('');
        }

    });
    $('.doc_type').bind('change', function() {

        //this.files[0].size gets the size of your file.
        console.log(this.files[0])
        var file_size = this.files[0].size; //in byts;
        if (file_size > 10000000) {
            alert('File Size Must be less than 10 MB');
            $(this).val('');
        }

    });
   
    $('.profile_image').bind('change', function() {
        // alert('')
         //this.files[0].size gets the size of your file.
         console.log(this.files[0])
         var file_size = this.files[0].size; //in byts;
         if (file_size > 1000000) {
             alert('File Size Must be less than  1 MB');
             $(this).val('');
         }
 
     });

});
