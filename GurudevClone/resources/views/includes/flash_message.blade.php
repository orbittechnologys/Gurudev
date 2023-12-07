@push('page_scripts')
    <script>
        jQuery(document).ready(function($) {

            if ($.isFunction($.fn.toast)) {
                $.toast({
                    heading: 'Welcome To Pitnik',
                    text: '',
                    showHideTransition: 'slide',
                    icon: 'success',
                    loaderBg: '#fa6342',
                    position: 'bottom-right',
                    hideAfter: 3000,
                });

                $.toast({
                    heading: 'Information',
                    text: 'Now you can full demo of pitnik and hope you like',
                    showHideTransition: 'slide',
                    icon: 'info',
                    hideAfter: 5000,
                    loaderBg: '#fa6342',
                    position: 'bottom-right',
                });
                $.toast({
                    heading: 'Support & Help',
                    text: 'Report any <a href="#">issues</a> by email',
                    showHideTransition: 'fade',
                    icon: 'error',
                    hideAfter: 7000,
                    loaderBg: '#fa6342',
                    position: 'bottom-right',
                });
            }

        });
    </script>
@endpush