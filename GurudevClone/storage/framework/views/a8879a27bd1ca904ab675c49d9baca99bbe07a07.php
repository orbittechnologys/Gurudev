<header class="main-header">
    <div class="d-flex align-items-center logo-box justify-content-start">

        <!-- Logo -->
        <a href="#" class="logo">
            <!-- logo-->
            <div class="logo-lg">
                <span class="light-logo"><img src="<?php echo e(asset('/user/images/logo-dark-text.png')); ?>" class="logo-img" alt="logo"></span>
                <span class="dark-logo"><img src="<?php echo e(asset('/user/images/logo-dark-text.png')); ?>" class="logo-img" alt="logo"></span>
            </div>
        </a>
    </div>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
        <div class="wf">
            <div id="wf_qb">
                <div class="wf_qb">
                    <div id="wf_qb_infohead" class="wf-header-1">
                        <h4 class="wf_bright" style="display: inline-block"><?php echo e($questions['quiz_name']); ?></h4>
                        <br>
                        <b><i class="fa fa-arrow-circle-left cursor-pointer"></i> Question
                            <span class="question_counter">1</span> of <span
                                    id="total_question_count"><?php echo e($questions['total_questions']); ?></span></b> <i
                                class="fa fa-arrow-circle-right cursor-pointer"></i><br>
                    </div>
                </div>
            </div>
        </div>
        <div id="timer">
            <div id="hours"></div>
            <div id="minutes"></div>
            <div id="seconds"></div>
        </div>
        <!-- This is for category wise timer -->
        <div id="timer_special_test">
            <div id="special_test_hours"></div>
            <div id="special_test_minutes"></div>
            <div id="special_test_seconds"></div>
        </div>
    </nav>
</header>
<?php /**PATH C:\Users\91701\Downloads\gurudev\GurudevClone\resources\views/includes/user/onlineTeastHeader.blade.php ENDPATH**/ ?>