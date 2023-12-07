<?php $__currentLoopData = $questions['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <li class="draggable-item" data-id="<?php echo e($list['id']); ?>"> <b class="index_counter"></b> <?php echo $list['question']; ?></li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php if(sizeof($questions)==0): ?>
    <li class="noRecord"><h4>No Questions Found!!</h4></li>
<?php endif; ?>
<?php if($questions['total']>500): ?>
<div id="pagination" class="row mb-30">
    <div class="col-lg-12">
        <div class="mb-5">
            <ul class="pagination" style=" width: 300px; margin: auto;">
                <li class="page-item page-prev <?php echo e(($questions['current_page']==1) ? 'disabled' : ''); ?>">
                    <a class="page-link" href="javascript:void(0);" onclick="myPagination('<?php echo e($questions['prev_page_url']); ?>','full_url')" tabindex="-1">Previous</a>
                </li>

                <?php for($i=1;$i<=$questions['last_page'];$i++): ?>

                    <?php if($questions['current_page']<=4): ?>
                        <li class="page-item <?php echo e(($i==$questions['current_page']) ? 'active' : ''); ?>"><a class="page-link" href="javascript:void(0)" onclick="myPagination(<?php echo e($i); ?>)" ><?php echo e($i); ?></a></li>
                    <?php endif; ?>


                    <?php if($i>=5): ?>
                        <?php if($questions['current_page']>=5): ?>
                            <li class="page-item <?php echo e((1==$questions['current_page']) ? 'active' : ''); ?>"><a class="page-link"href="javascript:void(0)" onclick="myPagination(1)" ><?php echo e(1); ?></a></li>
                            <li class="page-item"><a class="page-link" style="cursor: default;">...</a></li>
                            <li class="page-item <?php echo e(($questions['current_page']-1==$questions['current_page']) ? 'active' : ''); ?>"><a class="page-link" href="javascript:void(0)" onclick="myPagination(<?php echo e($questions['current_page']-1); ?>)" ><?php echo e($questions['current_page']-1); ?></a></li>
                            <li class="page-item <?php echo e(($questions['current_page']==$questions['current_page']) ? 'active' : ''); ?>"><a class="page-link" href="javascript:void(0)" onclick="myPagination(<?php echo e($questions['current_page']); ?>)" ><?php echo e($questions['current_page']); ?></a></li>
                            <?php if(($questions['current_page']+1)<$questions['last_page']): ?>
                                <li class="page-item <?php echo e(($questions['current_page']+1==$questions['current_page']) ? 'active' : ''); ?>"><a class="page-link" href="javascript:void(0)" onclick="myPagination(<?php echo e($questions['current_page']+1); ?>)" ><?php echo e($questions['current_page']+1); ?></a></li>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if($questions['current_page']!=$questions['last_page'] && ($questions['current_page']+1)!=$questions['last_page']): ?>
                            <li class="page-item"><a class="page-link" style="cursor: default;">...</a></li>
                            <li class="page-item <?php echo e(($questions['last_page']==$questions['current_page']) ? 'active' : ''); ?>"><a class="page-link" href="javascript:void(0)" onclick="myPagination(<?php echo e($questions['last_page']); ?>)" ><?php echo e($questions['last_page']); ?></a></li>
                        <?php endif; ?>
                        <?php break; ?>
                    <?php endif; ?>
                <?php endfor; ?>
                <li class="page-item page-next <?php echo e(($questions['current_page']==$questions['last_page']) ? 'disabled' : ''); ?>">
                    <a class="page-link" href="javascript:void(0)" onclick="myPagination('<?php echo e($questions['next_page_url']); ?>', 'full_url')" >Next</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php endif; ?>
<script>
    console.log(' total Questions <?php echo e($questions['total']); ?>')
    var questions ='<?php echo json_encode($questions['data']); ?>';
    questions=JSON.parse(questions);
    if(questions.length==0)
        $('.listed_questions').addClass('selectCourse');

    for(i=0;i<$('.listed_questions li').length;i++){
       $($('.listed_questions li')[i]).find('.index_counter').text(i+1+'. ')
    }


</script>
<script>

    id = $('.subjects_tab[class*="active"]').attr('data-id')
    $(".droppable-area2 li").attr('data-subject', id)
</script>
<?php /**PATH C:\Users\91701\Downloads\gurudev\GurudevClone\resources\views/Quiz/questionsDragDrop.blade.php ENDPATH**/ ?>