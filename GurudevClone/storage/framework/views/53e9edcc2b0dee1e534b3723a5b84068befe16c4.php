<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="side-tab-body p-0 border-0" id="sidemenu-Tab">
        <div class="first-sidemenu ps ps--active-y">
            <ul class="resp-tabs-list hor_1">
                <?php $__currentLoopData = $userRoleMainMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mainMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(sizeof($mainMenu['sub_module'])>1): ?>
                        <li class="MainMenu "><i class="<?php echo e($mainMenu['icon_name']); ?>"></i><span class="side-menu__label"><?php echo e($mainMenu['module_name']); ?></span></li>
                    <?php else: ?>
                        <a href="<?php echo e(url($mainMenu['sub_module'][0]['url'])); ?>">
                            <li class="text-white">
                                <i class="<?php echo e($mainMenu['icon_name']); ?>"></i>
                                <span class="side-menu__label"><?php echo $mainMenu['module_name']; ?></span>
                            </li>
                        </a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <div class="second-sidemenu">
            <div class="resp-tabs-container hor_1">
                <?php //print_r($userRoleMainMenu); ?>
                <?php $__currentLoopData = $userRoleMainMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mainMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(sizeof($mainMenu['sub_module'])>1): ?> <?php //print_r($mainMenu); ?>
                    <div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel sidetab-menu">
                                    <div class="panel-body tabs-menu-body p-0 border-0">
                                        <div class="tab-content">
                                            <div class="tab-pane active " id="side61">
                                                <h5 class="mt-3 mb-4"><?php echo e($mainMenu['module_name']); ?></h5>
                                                <?php $__currentLoopData = $mainMenu['sub_module']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                    <?php if($submenu['url']!='' && $submenu['level']=='Level1'): ?>

                                                        <a href="<?php echo e(url($submenu['url'])); ?>" class="slide-item"> <?php echo $submenu['sub_module_name']; ?></a>

                                                    <?php elseif($submenu['url']==''): ?>

                                                        <div class="side-menu p-0">
                                                            <div class="slide submenu">
                                                                <a class="side-menu__item" data-toggle="slide" href="#"><span class="side-menu__label"><?php echo e($submenu['sub_module_name']); ?></span><i class="angle fa fa-angle-down"></i></a>
                                                                <ul class="slide-menu submenu-list">

                                                                    <?php $__currentLoopData = $mainMenu['sub_module']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $secondLevel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php if($secondLevel['level']=='Level2' && $secondLevel['under']==$submenu['id'] && $secondLevel['url']!=''): ?>
                                                                            <li><a href="<?php echo e(url($secondLevel['url'])); ?>" class="slide-item"><?php echo e($secondLevel['sub_module_name']); ?></a></li>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                                </ul>
                                                            </div>
                                                        </div>

                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                        <div></div>
                    <?php endif; ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

    </div>
</aside>
<!--sidemenu end--><?php /**PATH C:\Users\91701\Downloads\gurudev\GurudevClone\resources\views/includes/sidebar.blade.php ENDPATH**/ ?>