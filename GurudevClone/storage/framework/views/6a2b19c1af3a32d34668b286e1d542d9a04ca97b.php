<?php $__env->startSection('title', 'Key Answers'); ?>
<?php $__env->startPush('page_styles'); ?>
    <style>
        .question div,
        .question h1,
        .question h2,
        .question h3,
        .question h4,
        .question h5 {
            display: inline;
        }

        .ribbon-bookmark.ribbon-right {
            right: -5px;
            left: auto;
        }

        .ribbon-bookmark {
            border-radius: 0;
            top: -5px;
            left: -5px;
        }

        .ribbon {
            padding: 0 20px;
            height: 30px;
            line-height: 30px;
            clear: left;
            position: absolute;
            top: 0px;
            left: -2px;
        }

        .ribbon-bookmark.ribbon-right.bg-danger:before {
            border-right-color: #fc4b6c;
            border-left-color: transparent;
        }

        .ribbon-bookmark.bg-danger:before {
            border-color: #fc4b6c;
            border-right-color: transparent;
        }

        .ribbon-bookmark.ribbon-right:before {
            right: 100%;
            left: auto;
            border-right: 15px solid #2b2b2b;
            border-left: 10px solid transparent;
        }

        .theme-primary .bg-danger {
            background-color: #fc4b6c !important;
            color: #ffffff;
        }

        .ribbon-bookmark:before {
            position: absolute;
            top: 0;
            left: 100%;
            display: block;
            width: 0;
            height: 0;
            content: '';
            border: 15px solid #2b2b2b;
            border-right: 10px solid transparent;
        }

        hr.question-details {
            border-top: 1px dotted red;
            width: 100%;
            margin: 10px 0;
            padding: 0;
        }

        .bg-danger {
            background-color: #fc4b6c !important;
            color: #fff;
        }

        /*----------------------------------- Quiz Test Page -------------------------------------*/
        .quiz-ans-list {
            display: grid;
        }

        .quiz-ans-list .custom-control-label:before {
            width: 20px !important;
            height: 20px !important;
        }

        .quiz-ans-list .custom-control-label:after {
            width: 20px !important;
            height: 20px !important;
        }

        .quiz-ans-list .custom-control-label {
            font-size: 16px;
        }

        .quiz-ans-list li {
            padding-bottom: 10px;
        }

        div#wf_qb div.wf_qb1_answer_row {
            border: none;
            box-shadow: 0 0 12px 1px rgba(110, 109, 109, 0.25);
        }

        .right_answer {
            background-image: linear-gradient(45deg, #0dbc35, #08d3a0);
            color: white;
            box-shadow: 0 0 12px 1px rgb(24, 209, 141) !important;
        }

        .right_answer_selected {}

        .wrong_answer_selected {
            background-image: linear-gradient(45deg, #f50c16, #ff4477);
            color: white;
            box-shadow: 0 0 12px 1px rgb(209, 102, 167) !important;
        }



        .hr-line-3 {
            width: 100%;
            height: 2px;
            background-image: linear-gradient(90deg, #11ffcc, #4695f8, #a966f8, #ff3243);
            border-radius: 15px;
        }

        .font-weight-600 {
            font-weight: 600;
        }

        .percentage {
            position: absolute;
            right: 20px;
            top: 10px;
        }

        .col {
            min-width: 120px;
        }

        .question {
            display: inline-flex;
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
    </style>
    <?php echo e(Html::style('user/quiz/css/wf_qb.css')); ?>

    <?php echo e(Html::style('user/quiz/css/wf.css')); ?>

    <?php echo e(Html::style('user/stepzation-master/animate.css')); ?>

    <?php echo e(Html::style('user/stepzation-master/style.css')); ?>

    <?php echo e(Html::style('User/app-assets/css/plugins/extensions/swiper.min.css')); ?>

    <?php echo Html::style('User/app-assets/vendors/css/charts/apexcharts.css'); ?>

    <?php echo Html::style('User/app-assets/css/core/colors/palette-gradient.min.css'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <section class="content d-flex flex-column">
        <!-- parallax swiper start -->


        <div class="row order-2" id="questions">
            <div class=" col-lg-12 col-12">
                <?php
                $subjectArrayCount = [];
                $subjects = json_decode($key_answers['quiz']['questions_category_details'], true);
                ?>
                <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    $subjectArrayCount[$key]['answered-and-mark'] = 0;
                    $subjectArrayCount[$key]['Answered'] = 0;
                    $subjectArrayCount[$key]['not-answered'] = 0;
                    $subjectArrayCount[$key]['review'] = 0;
                    $subjectArrayCount[$key]['not-visited'] = 0;
                    $subjectArrayCount[$key]['total'] = 0;
                    ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php ($negativeCount = 0); ?>
                <?php ($wrongAnsCount = 0); ?><?php ($unAttended = 0); ?><?php ($answeredCount = 0); ?>
                <?php $__currentLoopData = $key_answers['quiz']['quiz_detail']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php ($answered = false); ?>
                    <?php ($notVisited = true); ?>
                    <?php ($subjectArrayCount[$question['category']]['total']++); ?>
                    <div class="card">
                        <div class="card-body pt-30">
                            <h4 class="question">
                                <div class="question_counter mt-3 mr-10">
                                    <?php echo e(sprintf('%02d', $loop->iteration) . '.'); ?>

                                </div>
                                <div><?php echo $question['question']['question']; ?></div>
                            </h4>

                            <div class="hr-line-3 my-2"></div>
                            <div class="wf">
                                <div id="wf_qb">
                                    <div class="wf_qb">
                                        <div id="wf_qb_answer" style="margin-top:20px;">
                                            <div id="wf_qb_answer_input" class="row">

                                                <?php ($alphabet = 'A'); ?>
                                                <?php ($wrong_answer = ''); ?>
                                                <?php ($correct_answer = $question['question']['correct_answer']); ?>
                                                <?php $__currentLoopData = $key_answers['user_quiz_question_detail']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $given_answers): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($question['question']['id'] == $given_answers['question_id']): ?>
                                                        <?php ($notVisited = false); ?>
                                                        <?php ($subjectArrayCount[$given_answers['category']][$given_answers['status']]++); ?>
                                                        <?php if($given_answers['given_answer'] != ''): ?>
                                                            <?php ($answered = true); ?>
                                                            <?php ($answeredCount++); ?>
                                                            <?php if($question['question']['correct_answer'] == $given_answers['given_answer']): ?>
                                                                <?php ($correct_answer_colour = 'right_answer'); ?>
                                                            <?php else: ?>
                                                                <?php
                                                                $correct_answer_colour = 'right_answer';
                                                                $wrong_answer_colour = 'wrong_answer';
                                                                $wrong_answer = $given_answers['given_answer'];
                                                                $wrongAnsCount++;
                                                                ?>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php for($i = 1; $i <= 6; $i++): ?>
                                                    <?php ($answer_class = ''); ?>
                                                    <?php if('answer' . $i == $question['question']['correct_answer']): ?>
                                                        <?php ($answer_class = 'right_answer'); ?>
                                                    <?php elseif($wrong_answer != '' && $wrong_answer == 'answer' . $i): ?>
                                                        <?php ($answer_class = 'wrong_answer_selected'); ?>
                                                        <?php if($question['question']['negative_marking'] > 0): ?>
                                                            <?php ($negativeCount++); ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>


                                                    <?php if($question['question']['answer' . $i] != ''): ?>
                                                        <div class="col-md-6 px-1">
                                                            <div class="wf_qb1_answer_row <?php echo e($answer_class); ?>">
                                                                <div class="wf_qb1_answer_row_inner">
                                                                    <span
                                                                        class="wf_qb1_answer_col1"><?php echo e($alphabet); ?></span>
                                                                    <span
                                                                        class="wf_qb1_answer_col2"><?php echo $question['question']['answer' . $i]; ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>



                                                    <?php ($alphabet++); ?>
                                                <?php endfor; ?>
                                                <hr class="question-details" />
                                                <div class="col-lg-12 mt-2">
                                                    <div class="pull-right">
                                                        <span class="badge badge-success mr-3 p-1">Marks:
                                                            <?php echo e($question['question']['marks']); ?></span>
                                                        <?php if($question['question']['negative_marking'] > 0): ?>
                                                            <span class="badge badge-danger p-1"> Negative Marking
                                                                <?php echo $question['question']['negative_marking']; ?></span>
                                                        <?php endif; ?>
                                                    </div>

                                                    <b>Description :</b><?php echo $question['question']['description']; ?>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if($notVisited == true): ?>
                            <?php ($unAttended++); ?>
                            <?php ($subjectArrayCount[$question['category']]['not-visited']++); ?>
                        <?php endif; ?>
                        <?php if($answered == false): ?>
                            <div class="ribbon ribbon-bookmark ribbon-right bg-danger">Not Answered</div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        </div>
        <div class="row order-1" id="category-details">
            <div class="col-md-12">
                <div class="card " id="marks-detail">
                    <div class="card-header">
                        <div class="card-title ">
                            <h5>
                                <?php echo e($key_answers['quiz']['special_course']['course']); ?> :
                                <?php if($key_answers['quiz']['st_sub_course']['title'] != ''): ?>
                                    <?php echo e($key_answers['quiz']['st_sub_course']['title']); ?> :
                                <?php endif; ?>
                                <?php if($key_answers['quiz']['quiz_name'] != ''): ?>
                                    <?php echo e($key_answers['quiz']['quiz_name']); ?>

                                <?php endif; ?>
                            </h5>
                        </div>
                        <div class="card-controls pull-right">

                            <div class="col">
                                <div class="text-center">
                                    <span class="font-large-1"><?php echo e($key_answers['total_time_taken']); ?> </span>
                                    <p class="font-weight-600">Minutes</p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="text-center">
                                    <span class="font-large-1"><?php echo e($key_answers['quiz']['total_time'] . ':00'); ?> </span>
                                    <p class="font-weight-600">Total Minutes</p>
                                </div>
                            </div>
                            <div class="col">
                                <?php ($percentage = ($key_answers['obtained_marks'] / $key_answers['total_marks']) * 100); ?>
                                <div class="text-center">
                                    <span class="font-large-1"><?php echo e($percentage > 0 ? (int) $percentage : 0); ?>%</span>
                                    <p class="font-weight-600">Result</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">


                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col">
                                        <div class="text-center text-primary">
                                            <span class="font-large-1"><?php echo e($key_answers['quiz']['total_questions']); ?></span>
                                            <p class="font-weight-600">Total </p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="text-center text-gray">
                                            <span
                                                class="font-large-1"><?php echo e(sizeof($key_answers['user_quiz_question_detail'])); ?></span>
                                            <p class="font-weight-600">Attended </p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="text-center text-gray">
                                            <span class="font-large-1"><?php echo e($answeredCount); ?></span>
                                            <p class="font-weight-600">Answered </p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="text-center text-success">
                                            <span class="font-large-1 "><?php echo e($answeredCount - $wrongAnsCount); ?></span>
                                            <p class="font-weight-600">Correct </p>
                                        </div>
                                    </div>
                                    <div class="col" style="border-right: 2px solid #c0c2c3;">
                                        <div class="text-center text-danger">
                                            <span class="font-large-1 "><?php echo e($wrongAnsCount); ?></span>
                                            <p class="font-weight-600">Wrong </p>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col">

                                    </div>
                                    <div class="col">
                                        <div class="text-center text-gray">
                                            <span class="font-large-1"><?php echo e($unAttended); ?></span>
                                            <p class="font-weight-600">Un Attended</p>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="text-center text-gray">
                                            <span
                                                class="font-large-1 "><?php echo e(sizeof($key_answers['user_quiz_question_detail']) - $answeredCount); ?></span>
                                            <p class="font-weight-600">Not Answered </p>
                                        </div>
                                    </div>
                                    <div class="col">

                                    </div>
                                    <div class="col" style="border-right: 2px solid #c0c2c3;">

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col">
                                        <div class="text-center text-info">
                                            <span class="font-large-1"><?php echo e($key_answers['total_marks']); ?></span>
                                            <p class="font-weight-600">Total Marks </p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="text-center text-success">
                                            <span
                                                class="font-large-1"><?php echo e(abs($key_answers['obtained_marks'] + $key_answers['negative_marks'])); ?></span>
                                            <p class="font-weight-600">Obtained Marks </p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="text-center text-danger">
                                            <span class="font-large-1"><?php echo e($key_answers['negative_marks']); ?></span>
                                            <p class="font-weight-600">-Ve Marks</p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="text-center text-success">
                                            <span class="font-large-1"><?php echo e($key_answers['obtained_marks']); ?></span>
                                            <p class="font-weight-600">Final Marks </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <?php $__currentLoopData = $subjectArrayCount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject => $subjectCount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="dropdown mr-15">
                                    <button class="btn btn-rounded btn-outline btn-info dropdown-toggle" type="button"
                                        data-toggle="dropdown"><?php echo e($subject); ?></button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item flexbox pb-0 pt-0" href="#">
                                            <span class="text-bold">Answered</span>
                                            <span class="badge badge-pill badge-lg answered_count">
                                                <?php echo e(str_pad($subjectCount['Answered'], 2, 0, STR_PAD_LEFT)); ?>

                                            </span>
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item flexbox pb-0 pt-0" href="#">
                                            <span class="text-bold">Not Answered</span>
                                            <span class="badge badge-pill badge-lg not_answered_count">
                                                <?php echo e(str_pad($subjectCount['not-answered'], 2, 0, STR_PAD_LEFT)); ?>

                                            </span>
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item flexbox pb-0 pt-0" href="#">
                                            <span class="text-bold">Not Visited</span>
                                            <span class="badge badge-pill badge-lg not_visited_count">
                                                <?php echo e(str_pad($subjectCount['not-visited'], 2, 0, STR_PAD_LEFT)); ?>

                                            </span>
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item flexbox pb-0 pt-0" href="#">
                                            <span class="text-bold">Marked For Review</span>
                                            <span class="badge marked_review_count badge-lg badge-pill">
                                                <?php echo e(str_pad($subjectCount['review'], 2, 0, STR_PAD_LEFT)); ?>

                                            </span>
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item flexbox pb-0 pt-0" href="#">
                                            <span class="text-bold">Answered And Marked For Review</span>
                                            <span class="badge badge-pill badge-lg answered_mark_review_count">
                                                <?php echo e(str_pad($subjectCount['answered-and-mark'], 2, 0, STR_PAD_LEFT)); ?>

                                            </span>
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item flexbox pb-0 pt-0" href="#">
                                            <span class="text-bold">Total</span>
                                            <span class="badge badge-pill badge-lg badge-warning">
                                                <?php echo e(str_pad($subjectCount['total'], 2, 0, STR_PAD_LEFT)); ?>

                                            </span>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                        </div>

                    </div>
                </div>
            </div>
        </div>


    </section>
    <?php
    
    function time_to_decimal($time)
    {
        $timeArr = explode(':', $time);
        $decTime = $timeArr[0] * 60 + $timeArr[1] + $timeArr[2] / 60;
    
        return $decTime;
    }
    ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('includeJs'); ?>
    <script>
        // $('.wrongAnsCount').html('<?php echo e($wrongAnsCount); ?>')
        $(window).on('popstate', function(event) {
            alert("pop");
        });
        if (window.event.clientX < 40 && window.event.clientY < 0) {
            alert("Browser back button is clicked...");
        } else {
            alert("Browser refresh button is clicked...");
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.userMain', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\91701\Downloads\gurudev\GurudevClone\resources\views/User/specialTestKeyAnswers.blade.php ENDPATH**/ ?>