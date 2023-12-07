<?php $__env->startSection('title', 'Special Test'); ?>
<?php $__env->startSection('content'); ?>

    <!-- BEGIN: Page CSS-->
    <?php echo e(Html::style('user/quiz/css/wf_qb.css')); ?>

    <?php echo e(Html::style('user/quiz/css/wf.css')); ?>

    <?php echo e(Html::style('user/quiz/css/swiper.min.css')); ?>

    <?php echo e(Html::style('user/quiz/stepzation-master/animate.css')); ?>

    <?php echo e(Html::style('user/quiz/stepzation-master/style.css')); ?>

    <?php echo e(Html::style('user/quiz/css/apexcharts.css')); ?>

    <?php echo e(Html::style('user/quiz/css/palette-gradient.min.css')); ?>


    <?php
    header('Cache-Control: no-store, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Expires: ' . date('d-M-Y H:i:s'));
    ?>

<?php $__env->startSection('content'); ?>
    <style>
        .loading {
            position: fixed;
            z-index: 999;
            height: 2em;
            width: 2em;
            overflow: show;
            margin: auto;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
        }

        /* Transparent Overlay */
        .loading:before {
            content: '';
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(rgba(20, 20, 20, .8), rgba(0, 0, 0, .8));

            background: -webkit-radial-gradient(rgba(20, 20, 20, .8), rgba(0, 0, 0, .8));
        }

        /* :not(:required) hides these rules from IE9 and below */
        .loading:not(:required) {
            /* hide "loading..." text */
            font: 0/0 a;
            color: transparent;
            text-shadow: none;
            background-color: transparent;
            border: 0;
        }

        .loading:not(:required):after {
            content: '';
            display: block;
            font-size: 10px;
            width: 1em;
            height: 1em;
            margin-top: -0.5em;
            -webkit-animation: spinner 150ms infinite linear;
            -moz-animation: spinner 150ms infinite linear;
            -ms-animation: spinner 150ms infinite linear;
            -o-animation: spinner 150ms infinite linear;
            animation: spinner 150ms infinite linear;
            border-radius: 0.5em;
            -webkit-box-shadow: rgba(255, 255, 255, 0.75) 1.5em 0 0 0, rgba(255, 255, 255, 0.75) 1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) 0 1.5em 0 0, rgba(255, 255, 255, 0.75) -1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) -1.5em 0 0 0, rgba(255, 255, 255, 0.75) -1.1em -1.1em 0 0, rgba(255, 255, 255, 0.75) 0 -1.5em 0 0, rgba(255, 255, 255, 0.75) 1.1em -1.1em 0 0;
            box-shadow: rgba(255, 255, 255, 0.75) 1.5em 0 0 0, rgba(255, 255, 255, 0.75) 1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) 0 1.5em 0 0, rgba(255, 255, 255, 0.75) -1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) -1.5em 0 0 0, rgba(255, 255, 255, 0.75) -1.1em -1.1em 0 0, rgba(255, 255, 255, 0.75) 0 -1.5em 0 0, rgba(255, 255, 255, 0.75) 1.1em -1.1em 0 0;
        }

        /* Animation */

        @-webkit-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @-moz-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @-o-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes  spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
    </style>
    <!-- BEGIN: Page CSS-->








    <!-- END: Page CSS-->
    <style>
        #timer {
            right: 300px;
            margin-top: -10px;
            display: inline-flex;
            position: absolute;
            margin-right: auto;
            line-height: 1;
            padding: 20px;
            font-size: 40px;
        }

        #hours {
            font-size: 30px;
            color: #fa6342;
        }

        #minutes {
            font-size: 30px;
            color: #fa6342;
        }

        #seconds {
            font-size: 30px;
            color: #fa6342;
        }

        #timer_special_test {
            right: 10px;
            margin-top: -10px;
            display: inline-flex;
            position: absolute;
            margin-right: auto;
            line-height: 1;
            padding: 20px;
            font-size: 40px;
        }

        #special_test_hours {
            font-size: 30px;
            color: #fa6342;
        }

        #special_test_minutes {
            font-size: 30px;
            color: #fa6342;
        }

        #special_test_seconds {
            font-size: 30px;
            color: #fa6342;
        }

        .paste-styled .step-by-step .step-by-step-step {
            width: 96%;
        }

        .card {
            margin-bottom: 0px;
        }

        .neg-m-t-30 {
            margin-top: -60px;
        }

        .my-modal-heading {
            font-size: 35px;
            font-weight: 100;
            padding-bottom: 20px;
        }

        .content-wrapper,
        .main-footer {
            margin-left: 30px;
            margin-right: 30px;
        }

        .modal-dialog-scrollable .modal-body {
            overflow-y: auto;
            overflow-x: hidden;
        }

        .modal-body {
            color: #475f7b;
        }
    </style>

    <style>
        div#wf_qb div.wf_qb1_answer_row {
            border: none;
            box-shadow: 0 0 12px 1px rgba(110, 109, 109, 0.25);
            margin-bottom: 10px !important;
        }

        div#wf_qb div.wf_qb1_answer_row_open:hover {
            background-image: linear-gradient(45deg, #0dbc35, #08d3a0);
            color: #fff;
            border: none;
            margin-bottom: 10px !important;

        }

        div#wf_qb div.wf_qb1_answer_row_inner {
            padding: 0;
        }

        .paste-styled .step-by-step .step-by-step-step .default-content {
            min-height: 260px;
        }

        .wf-header-1 {
            background-color: #fafbfd !important;
        }

        div#wf_qb div#wf_qb_infohead {
            box-shadow: none;
            margin-bottom: 0;
        }

        .paste-styled .step-by-step .step-by-step-step {
            width: 100%;
        }

        @media  screen and (max-width: 1199px) {
            #number-tabs {
                margin-top: 70px;
            }
        }

        .question>* {
            font-family: inherit !important;
            font-size: 20px !important;
            color: #475f7b !important;
        }

        .card .progress {
            margin-bottom: 0;
            height: 3px;
        }

        .paste-styled {
            border-top: none;
        }

        div#wf_qb div#wf_qb_infohead {
            box-shadow: none;
            padding: 0 !important;
        }

        .question div,
        .question h1,
        .question h2,
        .question h3,
        .question h4,
        .question h5 {
            display: inline;
        }

        .sa-button-container .cancel {
            background-color: #ff4164 !important;
        }

        .card-body {
            padding: 0.15rem;
        }

        .navbar .wf_qb {
            width: 74%;
        }
    </style>

    <div class="loading">Loading&#8230;</div>
    <style>
        .question div,
        .question h1,
        .question h2,
        .question h3,
        .question h4,
        .question h5 {
            display: inline;
        }

        .sa-button-container .cancel {
            background-color: #ff4164 !important;
        }

        .wf_qb1_answer_col1,
        .wf_qb1_answer_col2 {
            padding-top: 5px;
            padding-bottom: 5px;
        }
    </style>

    <style>
        .font-20 {
            font-size: 20px !important;
        }

        .img_mock_icon {
            width: 45px;
            height: 45px;
            margin-top: -5px;
        }

        .nav_top {
            background-color: #fff;
            z-index: 100;
            margin-bottom: 10px;
            padding: 5px 10px 2px 10px;
            border-radius: .5rem;
            box-shadow: 0 3px 12px 0 rgba(0, 0, 0, .1);
            position: fixed;
            width: 102%;
            top: 0;
        }

        @media  screen and (max-width: 1199px) {
            .nav_top {
                position: relative;
            }


        }

        .mt-nag-65 {
            margin-top: -65px;
        }

        .mock_title {
            margin-top: 8px;
            margin-left: 50px;
            margin-right: 170px;
        }

        .answered_count,
        .not_answered_count,
        .not_visited_count,
        .marked_review_count,
        .answered_mark_review_count,
        .question_counter_div {
            width: 35px;
            height: 35px;
            display: inline-block;
            border-radius: 50px;
            margin-top: 5px;
            margin-right: 5px;
            padding-top: 8px;
            text-align: center;
            color: #fff;
        }

        .question_counter_card {
            background-color: white;
            border-radius: 7px;
            box-shadow: 0 4px 25px 0 rgba(0, 0, 0, .1);
            -webkit-transition: all .3s ease-in-out;
        }

        .answered_count {
            background-color: #26aa3e !important;
            color: #fff !important;
        }

        .not_answered_count {
            background-color: #ff503a !important;
            color: #fff !important;
        }

        .not_visited_count {
            background-color: #e2e8ff;
            color: #9843ff;
        }

        .marked_review_count {
            background-color: #54b4de !important;
            color: #fff !important;
        }

        .answered_mark_review_count {
            background-color: #1c5ade !important;
            color: #fff !important;
        }

        .question_counter_div {
            background-color: #e2e8ff;
            color: #9843ff;
            cursor: pointer;
            margin: 5px;
        }

        .question_counter_div:hover,
        .activeQuestion {
            color: #fff;
            background-color: #c54cf7;
        }

        .hidden {
            display: none !important;
            visibility: hidden;
        }

        .slimScrollBar {
            background-color: #d0d1da !important;
            width: 4px !important;
        }

        .my-hover-card {
            position: absolute;
            border-radius: 7px;
            background-color: #fff;
            z-index: 999;
            width: 280px;
            display: none;
            margin-top: 2px;
            box-shadow: 0 0 10px #ddd;
            padding: 8px;

        }

        .nav-item:hover .my-hover-card {
            display: block;
        }

        .bottom-right-fixed {
            position: fixed;
            right: 5%;
            bottom: 120px;
        }

        .nav-item {
            list-style: none;
            display: inline-block;
            width: fit-content;
        }

        .btn_my {
            display: inline-block;
            width: auto;
            padding: 4px 8px !important;
            border: 2px solid #7029b7 !important;
            margin: 0 5px;
            color: #7029b7;
            border-radius: 5px;
            background-color: #fff;
        }

        .btn_my:hover,
        .active {
            background-color: #7029b7;
            color: #fff !important;
        }

        .my-card1-1 {
            background-color: white;
            box-shadow: 0 0 10px #ddd;
        }

        .result_counter {
            width: 45px !important;
            height: 45px !important;
            padding-top: 10px;
            font-size: 19px;
        }

        .content-wrapper {
            margin: 0 10px
        }

        .logo-img {
            margin-top: 14px;
        }

        .theme-primary .btn-danger {
            background-color: #d13939;
            border-color: #d13939;
            color: #ffffff;
        }

        .qu_parent {
            display: inline-flex;
        }

        .question_counter {
            margin-right: 10px;

        }
    </style>



    <div class="content-body fadeOutRight mt-5">

        <!-- parallax swiper start -->
        <section id="number-tabs">
            <div class="row p-1 ">
                <div class="col-12">
                    <div class="my-card-1 mb-1">

                        <?php ($i = 0); ?>
                        <?php ($subject_count = count($final_counter)); ?>
                        <?php ($category_info = json_decode($mock_details['user_quiz_detail']['category_info'], true)); ?>

                        <?php $__currentLoopData = $subject; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subKey => $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($subject_tot_count[$sub] > 0): ?>
                                <li class="nav-item">

                                    <a class="nav-link current_step btn_my" data-time="<?php echo e($subjectTime[$sub]); ?>"
                                        data-subject="<?php echo e($sub); ?>" data-tab-start="<?php echo e($final_counter[$i]); ?>"
                                        data-index="<?php echo e($i); ?>"
                                        data-category-spend-time="<?php echo e($category_info[$sub]); ?>" data-toggle="tab"
                                        href="javascript:void(0)" aria-selected="true"><?php echo e($sub); ?> </a>

                                    <div class="my-hover-card text-left">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="answered_count" data-subject="<?php echo e($sub); ?>"
                                                    data-time="<?php echo e($sub); ?>">
                                                    <?php echo e(0 + $subject_qu_counter[$sub]['answered']); ?></div> Answered
                                            </div>
                                            <div class="col-12">
                                                <div class="not_answered_count" data-subject="<?php echo e($sub); ?>">
                                                    <?php echo e(0 + $subject_qu_counter[$sub]['not_answered']); ?></div> Not Answered
                                            </div>
                                            <div class="col-12">
                                                <div class="not_visited_count" data-subject="<?php echo e($sub); ?>">
                                                    <?php echo e(0 + $subject_qu_counter[$sub]['not_visited']); ?></div> Not Visited
                                            </div>
                                            <div class="col-12">
                                                <div class="marked_review_count" data-subject="<?php echo e($sub); ?>">
                                                    <?php echo e(0 + $subject_qu_counter[$sub]['marked_review']); ?></div> Marked For
                                                Review
                                            </div>
                                            <div class="col-12">
                                                <div class="answered_mark_review_count" data-subject="<?php echo e($sub); ?>">
                                                    <?php echo e(0 + $subject_qu_counter[$sub]['answered_marked_review']); ?></div>
                                                Answered And Marked For Review
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php ($i++); ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>

                </div>
                <div class="col-md-9">
                    <div id="nav-filled">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="progress progress-bar-primary">
                                        <div id="process_quiz" class="progress-bar" role="progressbar" aria-valuenow="50"
                                            aria-valuemin="50" aria-valuemax="100"></div>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body px-1 py-0">

                                            <input type="hidden" id="mock_test_id" value="<?php echo e($mock_details['id']); ?>">
                                            <input type="hidden" id="course_id" value="<?php echo e($mock_details['course_id']); ?>">
                                            <input type="hidden" id="spend_time"
                                                data-mock-update-url="<?php echo e(url('specialTest/updateResult')); ?>"
                                                data-mock-spend-time="00:00:00"
                                                data-question-allocation-id="<?php echo e($mock_details['id']); ?>"
                                                data-user-mock-detail-id="<?php echo e($mock_details['user_quiz_detail']['id']); ?>"
                                                data-key-answer-url="<?php echo e(url('user/mock_test/list/2')); ?>">
                                            <input type="hidden" id="spend_time_active_category">
                                            <div class=" mt-1  overflow-hidden">
                                                <div class="card-body paste-styled pt-1 px-0 pb-0">
                                                    <div class='step-by-step' id='setup'>
                                                        <?php ($resume = 0); ?>
                                                        <?php ($j = 0); ?>
                                                        <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class='step-by-step-step split-h mr-10 ml-10'>
                                                                <div class="data_set"
                                                                    data-user-mock-question-detail-id="<?php echo e($question['umqd_id']); ?>"
                                                                    data-user-mock-detail-id="<?php echo e($mock_details['user_quiz_detail']['id']); ?>"
                                                                    data-subject-id="<?php echo e($question['category']); ?>"
                                                                    data-question-id="<?php echo e($question['question_id']); ?>"
                                                                    data-given-answer="<?php echo e($question['given_answer']); ?>"
                                                                    data-mark-review="<?php echo e($question['mark_review']); ?>"
                                                                    data-marks="<?php echo e($question['question']['marks']); ?>"
                                                                    data-correct-answer="<?php echo e($question['question']['correct_answer']); ?>"
                                                                    data-negetive-marks="<?php echo e($question['question']['negative_marking']); ?>"
                                                                    data-save-url="<?php echo e(url('specialTest/saveResult')); ?>">

                                                                </div>
                                                                <div class="q_a_div">

                                                                    <div
                                                                        class='default-content push-down centered-content maximize-height m-0'>
                                                                        <div class="qu_parent mt-2">
                                                                            <h4 class="question_counter">1 .</h4>
                                                                            <h4 class="question">
                                                                                <?php echo $question['question']['question']; ?> </h4>
                                                                        </div>

                                                                        <div class="wf">
                                                                            <div id="wf_qb">
                                                                                <div class="wf_qb">
                                                                                    <form id="wf_qb_form" method="post"
                                                                                        onsubmit="">
                                                                                        <div id="wf_qb_answer"
                                                                                            style="margin-top:20px;">
                                                                                            <div id="wf_qb_answer_input">
                                                                                                <div class="row ">
                                                                                                    <input type="hidden"
                                                                                                        class="corr_answer"
                                                                                                        value="<?php echo e($question['question']['correct_answer']); ?>">
                                                                                                    <?php if($question['question']['answer1'] != ''): ?>
                                                                                                        <div
                                                                                                            class="col-md-12 px-1">
                                                                                                            <div class="wf_qb1_answer_row wf_qb1_answer_row_open  <?php if('answer1' == $question['given_answer']): ?> wf_qb1_answer_row_done <?php endif; ?>"
                                                                                                                onclick="answer_selected(this,'answer1','<?php echo e($question['question']['id']); ?>','<?php echo e($question['category']); ?>')">
                                                                                                                <div
                                                                                                                    class="wf_qb1_answer_row_inner">
                                                                                                                    <input
                                                                                                                        type="radio"
                                                                                                                        name="answer_1"
                                                                                                                        value="1"
                                                                                                                        style="display:none;"><span
                                                                                                                        class="wf_qb1_answer_col1">A</span><span
                                                                                                                        class="wf_qb1_answer_col2"><?php echo $question['question']['answer1']; ?></span>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    <?php endif; ?>
                                                                                                    <?php if($question['question']['answer2'] != ''): ?>
                                                                                                        <div
                                                                                                            class="col-md-12 px-1">
                                                                                                            <div class="wf_qb1_answer_row wf_qb1_answer_row_open  <?php if('answer2' == $question['given_answer']): ?> wf_qb1_answer_row_done <?php endif; ?>"
                                                                                                                onclick="answer_selected(this,'answer2','<?php echo e($question['question']['id']); ?>','<?php echo e($question['category']); ?>')">
                                                                                                                <div
                                                                                                                    class="wf_qb1_answer_row_inner">
                                                                                                                    <input
                                                                                                                        type="radio"
                                                                                                                        name="answer_1"
                                                                                                                        value="2"
                                                                                                                        style="display:none;"><span
                                                                                                                        class="wf_qb1_answer_col1">B</span><span
                                                                                                                        class="wf_qb1_answer_col2"><?php echo $question['question']['answer2']; ?></span>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    <?php endif; ?>
                                                                                                    <?php if($question['question']['answer3'] != ''): ?>
                                                                                                        <div
                                                                                                            class="col-md-12 px-1">
                                                                                                            <div class="wf_qb1_answer_row wf_qb1_answer_row_open <?php if('answer3' == $question['given_answer']): ?> wf_qb1_answer_row_done <?php endif; ?>"
                                                                                                                onclick="answer_selected(this,'answer3','<?php echo e($question['question']['id']); ?>','<?php echo e($question['category']); ?>')">
                                                                                                                <div
                                                                                                                    class="wf_qb1_answer_row_inner">
                                                                                                                    <input
                                                                                                                        type="radio"
                                                                                                                        name="answer_1"
                                                                                                                        value="3"
                                                                                                                        style="display:none;"><span
                                                                                                                        class="wf_qb1_answer_col1">C</span><span
                                                                                                                        class="wf_qb1_answer_col2"><?php echo $question['question']['answer3']; ?></span>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    <?php endif; ?>
                                                                                                    <?php if($question['question']['answer4'] != ''): ?>
                                                                                                        <div
                                                                                                            class="col-md-12 px-1">
                                                                                                            <div class="wf_qb1_answer_row wf_qb1_answer_row_open <?php if('answer4' == $question['given_answer']): ?> wf_qb1_answer_row_done <?php endif; ?>"
                                                                                                                onclick="answer_selected(this,'answer4','<?php echo e($question['question']['id']); ?>','<?php echo e($question['category']); ?>')">
                                                                                                                <div
                                                                                                                    class="wf_qb1_answer_row_inner">
                                                                                                                    <input
                                                                                                                        type="radio"
                                                                                                                        name="answer_1"
                                                                                                                        value="4"
                                                                                                                        style="display:none;"><span
                                                                                                                        class="wf_qb1_answer_col1">D</span><span
                                                                                                                        class="wf_qb1_answer_col2"><?php echo $question['question']['answer4']; ?></span>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    <?php endif; ?>
                                                                                                    <?php if($question['question']['answer5'] != ''): ?>
                                                                                                        <div
                                                                                                            class="col-md-12 px-1">
                                                                                                            <div class="wf_qb1_answer_row wf_qb1_answer_row_open <?php if('answer5' == $question['given_answer']): ?> wf_qb1_answer_row_done <?php endif; ?>"
                                                                                                                onclick="answer_selected(this,'answer5','<?php echo e($question['question']['id']); ?>','<?php echo e($question['category']); ?>')">
                                                                                                                <div
                                                                                                                    class="wf_qb1_answer_row_inner">
                                                                                                                    <input
                                                                                                                        type="radio"
                                                                                                                        name="answer_1"
                                                                                                                        value="5"
                                                                                                                        style="display:none;"><span
                                                                                                                        class="wf_qb1_answer_col1">E</span><span
                                                                                                                        class="wf_qb1_answer_col2"><?php echo $question['question']['answer5']; ?></span>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    <?php endif; ?>
                                                                                                    <?php if($question['question']['answer6'] != ''): ?>
                                                                                                        <div
                                                                                                            class="col-md-12 px-1">
                                                                                                            <div class="wf_qb1_answer_row wf_qb1_answer_row_open <?php if('answer6' == $question['given_answer']): ?> wf_qb1_answer_row_done <?php endif; ?>"
                                                                                                                onclick="answer_selected(this,'answer6','<?php echo e($question['question']['id']); ?>','<?php echo e($question['category']); ?>')">
                                                                                                                <div
                                                                                                                    class="wf_qb1_answer_row_inner">
                                                                                                                    <input
                                                                                                                        type="radio"
                                                                                                                        name="answer_1"
                                                                                                                        value="6"
                                                                                                                        style="display:none;"><span
                                                                                                                        class="wf_qb1_answer_col1">F</span><span
                                                                                                                        class="wf_qb1_answer_col2"><?php echo $question['question']['answer6']; ?></span>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    <?php endif; ?>

                                                                                                </div>

                                                                                            </div>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php //if($question['question_id']==392) dd($mock_details);
                                                            ?>
                                                            <?php if(
                                                                ($question['umqd_id'] == $mock_details['user_quiz_detail']['last_attended_id'] ||
                                                                    $mock_details['user_quiz_detail']['last_attended_id'] == null) &&
                                                                    $resume == 0): ?>
                                                                <div class="hidden-resume-click current_step hidden"
                                                                    data-subject="<?php echo e($question['category']); ?>"
                                                                    data-tab-start="<?php echo e($j + 1); ?>">
                                                                    <?php echo e($j + 1); ?></div>
                                                                <?php ($resume = 1); ?>
                                                            <?php endif; ?>
                                                            <?php ($j++); ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                        <div class="my-footer my-1">

                                                            <button type="button"
                                                                class="btn bg-warning mr-1 mb-1 px-1 text-white"
                                                                id="clearResponse">Clear Response</button>

                                                            <button type="button"
                                                                class="btn bg-info mr-1 mb-1 px-1 text-white"
                                                                id="markForReview">Mark for Review & Next</button>
                                                            <button type="button"
                                                                class="btn bg-success mr-1 mb-1 px-1 text-white"
                                                                id="saveNext" disabled>Save & Next</button>

                                                            <button type="button"
                                                                class="btn bg-info mr-1 mb-1 px-1 text-white   hidden">Mark
                                                                for Review & Submit</button>
                                                            <button type="button"
                                                                class="btn bg-success mr-1 mb-1 px-1 text-white  finalSubmit hidden">Save
                                                                & Submit</button>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-1 mb-1">
                        <div class="row display_counter">
                            <div class="col-6">
                                <div class="answered_count final_answered_count">0</div> Answered
                            </div>
                            <div class="col-6">
                                <div class="not_answered_count final_not_answered_count">0</div> Not Answered
                            </div>
                            <div class="col-6 pt-1">
                                <div class="not_visited_count final_not_visited_count">0</div> Not Visited
                            </div>
                            <div class="col-6 pt-1">
                                <div class="marked_review_count final_marked_review_count">0</div> Marked For Review
                            </div>
                            <div class="col-12 pt-1">
                                <div class="answered_mark_review_count final_answered_mark_review_count">0</div> Answered
                                And Marked For Review
                            </div>
                        </div>
                    </div>
                    <div class="question_counter_card p-1 mb-1" align="center">
                        <h4>Choose a Question</h4>
                        <?php for($i = 0; $i < count($questions); $i++): ?>
                            <div class="question_counter_div current_step <?php echo e($questions[$i]['question_status']); ?> "
                                data-tab-start="<?php echo e($i + 1); ?>"><?php echo e($i + 1); ?></div>
                        <?php endfor; ?>
                    </div>

                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-primary finalSubmitMain">Submit</button>
                        <a href="javascript:void(0)" class=" btn btn-danger close-btn">Exit</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- parallax swiper ends -->
    </div>



    <div class="modal fade" id="ResultModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="chart-info d-flex justify-content-between mt-20">
                        <div class="text-center ">
                            <p class="mb-50 ">Total Time :<span
                                    class="font-weight-bold"><?php echo e($mock_details['total_time'] . ':00'); ?></span></p>
                        </div>

                        <div class="text-center ">
                            <p class="mb-50 ">Time Taken <span class="font-weight-bold time_taken"> </span></p>
                        </div>
                    </div>
                    <div class="row neg-m-t-30">
                        <div class="col-sm-12 col-12 d-flex justify-content-center">
                            <div id="support-tracker"></div>
                        </div>
                    </div>
                    <div class="chart-info d-flex justify-content-between mt-20">
                        <div class="text-center">

                        </div>
                        <div class="text-center">
                            <h4 class="mb-50 text-success my-modal-heading ">Congratulations</h4>

                        </div>
                        <div class="text-center">


                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col-md-1"></div>
                        <div class="col-md-2">
                            <div class="result_counter answered_count" data-toggle="tooltip" title="Answered">0</div>
                        </div>
                        <div class="col-md-2">
                            <div class="result_counter not_answered_count" data-toggle="tooltip" title="Not Answered">0
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="result_counter not_visited_count" data-toggle="tooltip" title="Not Visited">0
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="result_counter marked_review_count" data-toggle="tooltip"
                                title="Marked for Review">0</div>
                        </div>
                        <div class="col-md-2">
                            <div class="result_counter answered_mark_review_count" data-toggle="tooltip"
                                title="Answered & Marked for Review">0</div>
                        </div>

                    </div>
                    <hr>
                    <div class="text-center bg-black-10">
                        <b class="font-size-18 text-danger">Question Details</b>
                    </div>
                    <div class="chart-info d-flex justify-content-between font-weight-700 ">
                        <div class="text-center">
                            <p class="mb-0">Total</p>
                            <span class="font-large-1 total_questions"></span>
                        </div>
                        <div class="text-center">
                            <p class="mb-0">Attended</p>
                            <span class="font-large-1 attended_questions"></span>
                        </div>
                        <div class="text-center">
                            <p class="mb-0">Correct</p>
                            <span class="font-large-1 correct_questions"></span>
                        </div>
                        <div class="text-center">
                            <p class="mb-0">Wrong </p>
                            <span class="font-large-1 wrong_questions"></span>
                        </div>
                        <div class="text-center">
                            <p class="mb-0">Negative </p>
                            <span class="font-large-1 negative_questions"></span>
                        </div>
                    </div>
                    <div class="text-center bg-black-10 mt-30">
                        <b class="font-size-18 text-danger">Marks Details</b>
                    </div>
                    <div class="chart-info d-flex justify-content-between font-weight-700">
                        <div class="text-center">
                            <p class="mb-0">Total Marks</p>
                            <span class="font-large-1 total_marks"></span>
                        </div>
                        <div class="text-center">
                            <p class="mb-0">Obtained Marks</p>
                            <span class="font-large-1 obt_marks"></span>
                        </div>
                        <div class="text-center">
                            <p class="mb-0">Negative Marks</p>
                            <span class="font-large-1 negative_marks"></span>
                        </div>
                        <div class="text-center">
                            <p class="mb-0">Final Marks</p>
                            <span class="font-large-1 final_marks"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-success float-right close-btn">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="TimeCompleted" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body pt-10">
                                <div class="text-center">
                                    <div class="mt-5 mb-3">
                                        <i style="font-size: 120px" class="text-warning feather icon-alert-triangle"></i>
                                    </div>
                                    <h4 class="mb-5 text-warning my-modal-heading ">Time Completed ..!</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>







<?php $__env->stopSection(); ?>

<?php $__env->startPush('includeJs'); ?>
    <!-- BEGIN: Page Vendor JS-->
    <?php echo e(Html::script('user/quiz/stepzation-master/mock_stepzation.js')); ?>

    <?php echo e(Html::script('user/quiz/js/apexcharts.min.js')); ?>



    <script async>
        /************* REmove cmt after changes******/
        if (window.opener) {

        } else if (window.top !== window.self) {
            window.location="<?php echo e(url('user/mock_test/list')); ?>/"+'<?php echo e($mock_details['course_id']); ?>'
        } else {
            window.location="<?php echo e(url('user/mock_test/list')); ?>/"+'<?php echo e($mock_details['course_id']); ?>'
        }


        function chartDisplay(parsentage) {

            var e = "#7367F0",
                t = "#EA5455",
                r = "#FF9F43",
                o = "#9c8cfc",
                a = "#FFC085",
                s = "#f29292",
                i = "#b9c3cd",
                l = "#e7eef7";

            var p = {
                chart: {
                    height: 250,
                    type: "radialBar",
                    sparkline: {
                        enabled: !1
                    }
                },
                plotOptions: {
                    radialBar: {
                        size: 120,
                        offsetY: 20,
                        startAngle: -150,
                        endAngle: 150,
                        hollow: {
                            size: "60%"
                        },
                        track: {
                            background: "#fff",
                            strokeWidth: "100%"
                        },
                        dataLabels: {
                            value: {
                                offsetY: 20,
                                color: "#99a2ac",
                                fontSize: "2rem"
                            }
                        }
                    }
                },
                colors: [t],
                fill: {
                    type: "gradient",
                    gradient: {
                        shade: "dark",
                        type: "horizontal",
                        shadeIntensity: .5,
                        gradientToColors: [e],
                        inverseColors: !0,
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 100]
                    }
                },
                stroke: {
                    dashArray: 8
                },
                series: [parsentage],
                labels: ["Result"]
            }
            new ApexCharts(document.querySelector("#support-tracker"), p).render();
        }


        /****************************** Timer Start *********************************/

        var total_time_taken = '00:00:00';

        <?php if($mock_details['user_quiz_detail']): ?>
            total_time_taken = '<?php echo e($mock_details['user_quiz_detail']['total_time_taken']); ?>';
        <?php endif; ?>
        $('.wf_bright').html('<?php echo e($mock_details['quiz_name']); ?>')
        $('#total_question_count').html('<?php echo e($mock_details['total_questions']); ?>')

        var total_time = '<?php echo e($mock_details['total_time']); ?>:00';
        var time_taken_split = total_time_taken.split(':').map(function(item) {
            return parseInt(item, 10);
        });
        var total_time_split = total_time.split(':').map(function(item) {
            return parseInt(item, 10);
        });
        var total_sec_taken = ((+time_taken_split[0]) * 60 * 60) + ((+time_taken_split[1]) * 60) + (+time_taken_split[2]);
        var total_sec = ((+total_time_split[0]) * 60 * 60) + ((+total_time_split[1]) * 60) + (+total_time_split[2]);

        var remain_sec = total_sec - total_sec_taken;

        function afterCategoryActive(activeCategory) {
            document.getElementById('saveNext').disabled = true;
            //  alert('activeCategoryTimeTaken')
            var activeCategory = $(activeCategory)
            activeCategoryTime = $(activeCategory).attr('data-time') + ":00"
            var activeCategoryTimeSplit = activeCategoryTime.split(':').map(function(item) {
                return parseInt(item, 10);
            });

            var activeCategorySec = ((+activeCategoryTimeSplit[0]) * 60 * 60) + ((+activeCategoryTimeSplit[1]) * 60) + (+
                activeCategoryTimeSplit[2]);
            activeCategoryTimeTaken = $(activeCategory).attr('data-category-spend-time')
            var activeCategoryTimeTakenSplit = activeCategoryTimeTaken.split(':').map(function(item) {
                return parseInt(item, 10);
            });
            var activeCategorySecTaken = ((+activeCategoryTimeTakenSplit[0]) * 60 * 60) + ((+activeCategoryTimeTakenSplit[
                1]) * 60) + (+activeCategoryTimeTakenSplit[2]);
            var activeCategoryRemainingSec = activeCategorySec - activeCategorySecTaken
            //alert(activeCategoryTimeTaken)
            if (activeCategoryRemainingSec > 0) {
                //  alert();
                var activeCategoryEndTime = new Date();
                activeCategoryEndTime.setSeconds(activeCategoryEndTime.getSeconds() + activeCategoryRemainingSec);
                clearInterval(window.catTimer);
                activeCategoryEndTime = (Date.parse(activeCategoryEndTime) / 1000);
                var nextIndex = parseInt(activeCategory.attr('data-index')) + 1;
                var nextCategory = $('.nav-link[data-index=' + nextIndex + ']');
                function makeCategoryTimer() {
                    var now = new Date();
                    now = (Date.parse(now) / 1000);
                    var timeLeft = activeCategoryEndTime - now;
                    //let nextIndex = parseInt($(activeCategory).attr('data-index')) + 1

                    if (timeLeft <= 0) {
                        
                        document.getElementById('saveNext').disabled = false;
                        if (nextCategory.length == 0) {
                            clearInterval(window.catTimer);
                            $('#TimeCompleted').modal({
                                backdrop: 'static',
                                keyboard: false
                            });
                            $('#TimeCompleted').modal().show();

                            setTimeout(function() {
                                $('#TimeCompleted').modal().hide();
                                $('.finalSubmitMain').click();
                            }, 3000);
                            return;
                        }else{
                            // setTimeout(function () {
                                
                            //     $('.nav-link[data-index=' + nextIndex + ']').trigger('click');
                            // },3000);
                             $('.nav-link[data-index=' + nextIndex + ']').trigger('click');
                        }
                    }

                    var days = Math.floor(timeLeft / 86400);
                    var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
                    var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600)) / 60);
                    var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));

                    if (hours < "10") {
                        hours = "0" + hours;
                    }
                    if (minutes < "10") {
                        minutes = "0" + minutes;
                    }
                    if (seconds < "10") {
                        seconds = "0" + seconds;
                    }

                    $("#special_test_hours").html(hours + "<span>:</span>");
                    $("#special_test_minutes").html(minutes + "<span>:</span>");
                    $("#special_test_seconds").html(seconds + "<span></span>");

                    if (hours == 0 && minutes == 0 && seconds == 0) {
                        clearInterval(window.catTimer);
                    }

                    // console.log(hours+":"+minutes+":"+seconds);

                    d = Number(++activeCategorySecTaken);
                    var h = ("0" + Math.floor(d / 3600)).slice(-2);
                    var m = ("0" + Math.floor(d % 3600 / 60)).slice(-2);
                    var s = ("0" + Math.floor(d % 3600 % 60)).slice(-2);
                    cat_spend_time = h + ":" + m + ":" + s;
                    $(activeCategory).attr('data-category-spend-time', cat_spend_time);
                }

                window.catTimer = setInterval(function() {
                    makeCategoryTimer();
                }, 1000);

            }

        }


        var endTime = new Date();
        endTime.setSeconds(endTime.getSeconds() + remain_sec);
        var spend_time = 0;
        endTime = (Date.parse(endTime) / 1000);
        var timeLeft = 0

        // function makeTimer() {
        //     var now = new Date();
        //     now = (Date.parse(now) / 1000);
        //     timeLeft = endTime - now;
        //     if (timeLeft <= 0) {
        //         clearInterval(window.timer);
        //         $('#TimeCompleted').modal({
        //             backdrop: 'static',
        //             keyboard: false
        //         });
        //         $('#TimeCompleted').modal().show();

        //         setTimeout(function() {
        //             $('#TimeCompleted').modal().hide();
        //             $('.finalSubmitMain').click();
        //         }, 3000);
        //         return;
        //     }

        //     var days = Math.floor(timeLeft / 86400);
        //     var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
        //     var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600)) / 60);
        //     var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));

        //     if (hours < "10") {
        //         hours = "0" + hours;
        //     }
        //     if (minutes < "10") {
        //         minutes = "0" + minutes;
        //     }
        //     if (seconds < "10") {
        //         seconds = "0" + seconds;
        //     }

        //     $("#hours").html(hours + "<span>:</span>");
        //     $("#minutes").html(minutes + "<span>:</span>");
        //     $("#seconds").html(seconds + "<span></span>");

        //     if (hours == 0 && minutes == 0 && seconds == 0) {
        //         clearInterval(window.timer);
        //         $('#TimeCompleted').modal({
        //             backdrop: 'static',
        //             keyboard: false
        //         });
        //         $('#TimeCompleted').modal().show();

        //         setTimeout(function() {
        //             $('#TimeCompleted').modal().hide();
        //             $('.finalSubmitMain').click();
        //         }, 10000);
        //     }

        //     // console.log(hours+":"+minutes+":"+seconds);

        //     d = Number(++total_sec_taken);
        //     var h = ("0" + Math.floor(d / 3600)).slice(-2);
        //     var m = ("0" + Math.floor(d % 3600 / 60)).slice(-2);
        //     var s = ("0" + Math.floor(d % 3600 % 60)).slice(-2);
        //     spend_time = h + ":" + m + ":" + s;
        //     $('#spend_time').attr('data-mock-spend-time', spend_time);
        // }

        // window.timer = setInterval(function() {
        //     makeTimer();
        // }, 1000);


        /****************************** Timer End *********************************/

        $('.horizontal-menu-wrapper').css('display', 'none');

        $("#btn_show_result").click(function() {
            $('#TimeCompleted').modal().hide();
            show_result();
        });

        function show_result() {
            $('#ResultModal').modal({
                backdrop: 'static',
                keyboard: false
            });
            $('#ResultModal').modal().show();
            setTimeout(function() {
                key_answer();
            }, 30000);
        }


        /*---------------------------- Tab Slider Start -----------------------------*/
        document.addEventListener('DOMContentLoaded', function(e) {
            window.stepzation = new Stepzation(document.getElementById('setup'));
            stepzation.next_step_action = function(step) {
                return []; // ugly hack
            };

            stepzation.handle_error = function(error) {
                backdrop_error(error);
            };

            stepzation.handle_finish = function(step) {
                // alert('all steps done');
                // window.location.href = '/login';
            };

            stepzation.start();

            $('.hidden-resume-click').click(); //resume Mock Test to redirect Not visited Question
        });

        /*---------------------------- Tab Slider End -----------------------------*/



        /*---------------------------- On Answer Selected Start -----------------------------*/
        function answer_selected(event, answer, question_id, category) {
            //alert()
            $($(event).parent()).parent().find('.wf_qb1_answer_row').removeClass('wf_qb1_answer_row_done');
            $(event).addClass('wf_qb1_answer_row_done');

            var selected_ans = $(event).find('.wf_qb1_answer_col2').text();
            $('.step-by-step-step[data-active=1] div.data_set').attr('data-given-answer', answer);

        }
        /*---------------------------- On Answer Selected End -----------------------------*/



        /*---------------------------- Clear Response Start -----------------------------*/

        $('#clearResponse').click(function() {
            var current_question = $('.step-by-step-step[data-active=1]');
            current_question.find('.data_set').attr('data-given-answer', '');
            current_question.find('.data_set').attr('data-mark-review', 0);
            current_question.find('.wf_qb1_answer_row_done').removeClass('wf_qb1_answer_row_done');
        });

        /*---------------------------- Clear Response End -----------------------------*/
    </script>







    <script>
        var height = $(window).height();

        height = height - 290;
        $('.q_a_div').slimScroll({
            height: height + "px"
        });
        $('.loading').hide();

        function RefreshParent() {
            if (window.opener != null && !window.opener.closed) {
                window.opener.location.reload();
            }
        }
        window.onbeforeunload = RefreshParent;

        function disableF5(e) {
            if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 82) e.preventDefault();
        };

        $(document).ready(function() {
            $(document).on("keydown", disableF5);
        });
        $(this).bind("contextmenu", function(e) {
            e.preventDefault();
        });
        if(window.locationbar.visible){
            //alert(window.locationbar.visible)
            window.location='<?php echo e(url("fileNotFound")); ?>'
        }
        $('.back-btn, .close-btn').on('click', function() {
            window.close();
        })
        document.onkeydown = function(e) {
            if(e.keyCode == 123) {
                return false;
            }
            if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
                return false;
            }
            if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
                return false;
            }
            if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
                return false;
            }

            if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)){
                return false;
            }
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.userMain', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\91701\Downloads\gurudev\GurudevClone\resources\views/User/specialTest.blade.php ENDPATH**/ ?>