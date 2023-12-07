@if ($message = Session::get('success'))

    <div class='notify-alert alert alert-success col-xl-3 col-lg-3 col-md-3 col-12 animated fadeInDown' id='php-alert'>
        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><i class='fa fa-check'></i> {{ $message }}</div>
@elseif ($message = Session::get('warning'))

    <div class='notify-alert alert alert-warning col-xl-3 col-lg-3 col-md-3 col-12 animated fadeInDown' id='php-alert'>
        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><i class='fa fa-check'></i> {{ $message }}</div>
@elseif ($message = Session::get('danger') )

    <div class='notify-alert alert alert-danger col-xl-3 col-lg-3 col-md-3 col-12 animated fadeInDown' id='php-alert'>
        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><i class='fa fa-check'></i> {{ $message }}</div>
 @elseif ($message = Session::get('sweet-success'))
        <script>
            $(document).ready(function(){
                swal('','{!! $message  !!}', 'success');
            });

        </script>
@elseif ($message = Session::get('sweet-warning'))
    <script>
        $(document).ready(function(){
            swal('','{!! $message  !!}', 'warning');
        });

    </script>

@endif


<script>
    $("#php-alert").fadeOut(7000);
    $(".notify-alert").fadeOut(7000);
</script>



