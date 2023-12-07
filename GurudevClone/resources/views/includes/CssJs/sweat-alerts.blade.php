@if ($message = Session::get('sweet-success'))
    <script>
        $(document).ready(function(){
            swal('','{!! $message  !!}', 'success');
        });

    </script>
@elseif ($message = Session::get('sweet-warning'))
    <script>

        $(document).ready(function() {
            swal('', '{!! $message  !!}', 'warning');
        });
    </script>
@elseif ($message = Session::get('sweet-danger') )

    <script>
        $(document).ready(function() {
            swal('', '{!! $message  !!}', 'error');
        });
    </script>
@endif



