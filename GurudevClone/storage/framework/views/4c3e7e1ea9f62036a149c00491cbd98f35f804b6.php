<?php if($message = Session::get('sweet-success')): ?>
    <script>
        $(document).ready(function(){
            swal('','<?php echo $message; ?>', 'success');
        });

    </script>
<?php elseif($message = Session::get('sweet-warning')): ?>
    <script>

        $(document).ready(function() {
            swal('', '<?php echo $message; ?>', 'warning');
        });
    </script>
<?php elseif($message = Session::get('sweet-danger') ): ?>

    <script>
        $(document).ready(function() {
            swal('', '<?php echo $message; ?>', 'error');
        });
    </script>
<?php endif; ?>



<?php /**PATH C:\Users\91701\Downloads\gurudev\GurudevClone\resources\views/includes/CssJs/sweat-alerts.blade.php ENDPATH**/ ?>