<div class="pull-right">
    <?php if($model['id']!=''): ?>
        <?php echo e(Form::submit('Update',['class'=>'btn btn-info wrap ml-10'])); ?>

    <?php else: ?>
        <input type="reset" class="btn btn-default wrap" value="Cancel" />
        <?php echo e(Form::submit('Save',['class'=>'btn btn-info wrap ml-10'])); ?>

    <?php endif; ?>
</div>
<?php /**PATH C:\Users\91701\Downloads\gurudev\GurudevClone\resources\views/includes/save_update_button.blade.php ENDPATH**/ ?>