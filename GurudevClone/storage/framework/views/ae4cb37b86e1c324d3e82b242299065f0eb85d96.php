<?php $__env->startPush('includeCss'); ?>
    <style>
        .question div,
        .question h1,
        .question h2,
        .question h3,
        .question h4,
        .question h5 {
            display: inline;
            font-size: 22px !important;
        }

        .ui-datepicker {
            z-index: 2050 !important;
        }

        hr.question-details {
            border-top: 1px dotted red;
            width: 100%;
            margin: 10px 0;
            padding: 0;
        }



        .card-new1 {
            border: none;
            border-radius: 6px;
            box-shadow: 0 0 15px rgba(242, 242, 242, 0.75);
            transition: 0.3s;
            border: 1px solid #9ae2ff;
        }

        .back-btn {
            background-color: #e97979;
            border: 1px solid #c86565;
        }

        .back-btn:hover {
            color: #e97979 !important;
        }

        .neg-que {
            right: 0px;
            bottom: -9px;
            position: absolute;
        }

    </style>
    <?php echo $__env->make('includes.CssJs.advanced_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="mb-50">
        <div class="card card-new mt-15 p-3">
            <div class="float-right-3" data-toggle="modal" data-target="#quiz_description_modal"><i
                    class="fa fa-pencil"></i></div>
            <div class="card-new1  mt-5 p-4 ">
                <h4><b>Title :</b> <?php echo e($quiz_details['quiz_name']); ?></h4>
            </div>

            <?php if($quiz_details['type'] == 0): ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card-new1  mt-5 p-4">
                            <p class="h6 mb-4"><b>Course :</b> <?php echo e($quiz_details['course']['course']); ?></p>
                            <p class="h6 mb-4"><b>Subject :</b> <?php echo e($quiz_details['subject']['subject']); ?></p>
                            <p class="h6"><b>Chapter
                                    :</b> <?php echo e($quiz_details['chapter']['chapter']); ?></p>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="card-new1  mt-5 p-4">
                            <p class="h6"><b>Total Questions :</b> <?php echo e($quiz_details['total_questions']); ?></p>
                        </div>
                        <div class="card-new1  mt-5 p-4">
                            <p class="h6"><b>Duration (HH:MM):</b> <?php echo e($quiz_details['total_time']); ?></p>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="card-new1  mt-5 p-4">
                            <p class="h6"><b>Status :</b> <?php echo e($quiz_details['status']); ?></p>
                        </div>
                        <div class="card-new1  mt-5 p-4">
                            <p class="h6"><b>Publish Date
                                    :</b> <?php echo e(date('d M Y', strtotime($quiz_details['publish_date']))); ?></p>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="counter-div mt-4">
                            00
                        </div>
                        <h6 class="mt-3 text-center">Total Marks</h6>
                    </div>

                    <div class="col-md-10 p-4 pb-0">
                        <p class="text-justify"><b>Description :</b> <?php echo e($quiz_details['description']); ?></p>
                    </div>
                    <div class="col-md-2 p-4 pb-0">
                        <a href="<?php echo e(url('/admin/quiz/attended/' . $quiz_details['id'])); ?>"
                            class="float-right btn btn-primary"> Attended Details</a>
                    </div>
                </div>
            <?php elseif($quiz_details['type'] == 1): ?>
                <div class="row">

                    <div class="col-lg-2 col-md-12 col-sm-6">
                        <div class="card-new1  mt-5 p-4">
                            <p class="h6"><b>Type :</b>Current Affair</p>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-6">
                        <div class="card-new1  mt-5 p-4">
                            <p class="h6"><b>Total Questions :</b> <?php echo e($quiz_details['total_questions']); ?></p>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-6">
                        <div class="card-new1  mt-5 p-4">
                            <p class="h6"><b>Status :</b> <?php echo e($quiz_details['status']); ?></p>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-6">
                        <div class="card-new1  mt-5 p-4">
                            <p class="h6"><b>Publish Date
                                    :</b> <?php echo e(date('d M Y', strtotime($quiz_details['publish_date']))); ?></p>
                        </div>
                    </div>
                     <div class="col-lg-2 col-md-12 col-sm-6">
                        <div class="card-new1  mt-5 p-4">
                            <p class="h6"><b>Duration (H:M)
                                    :</b><?php echo e($quiz_details['total_time']); ?></p>
                        </div>
                    </div>
                    <div class="col ">
                        <div class="">
                            <p class="h6">
                                <div class="counter-div">
                                00
                            </div></p>
                        </div>
                    </div>

                    <div class="col-md-10 p-4 pb-0">
                        <p class="text-justify"><b>Description :</b> <?php echo e($quiz_details['description']); ?></p>
                    </div>
                    <div class="col-md-2 p-4 pb-0">
                        <a href="<?php echo e(url('/admin/quiz/attended/' . $quiz_details['id'])); ?>"
                            class="float-right btn btn-primary"> Attended Details</a>
                    </div>
                </div>
            <?php elseif($quiz_details['type'] == 2 || $quiz_details['type'] == 4): ?>
                <div class="row">

                    <div class="col ">
                        <div class="card-new1  mt-5 p-4">
                            <p class="h6"><b>Course :</b><?php echo e($quiz_details['special_course']['course']); ?></p>
                            <p class="h6 mb-4"><b>Sub Course :</b> <?php echo e($quiz_details['st_sub_course']['title']); ?></p>
                        </div>
                    </div>
                    <div class="col ">
                        <div class="card-new1  mt-5 p-4">
                            <p class="h6"><b>Type :</b>Test Series</p>
                        </div>
                    </div>
                    <div class="col ">
                        <div class="card-new1  mt-5 p-4">
                            <p class="h6"><b>Total Questions :</b> <?php echo e($quiz_details['total_questions']); ?></p>
                        </div>
                    </div>

                    <div class="col ">
                        <div class="card-new1  mt-5 p-4">
                            <p class="h6"><b>Status :</b> <?php echo e($quiz_details['status']); ?></p>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col ">
                        <div class="card-new1  mt-5 p-4">
                           <p class="h6"><b>Start Date Time
                                    </b><?php echo e(date('d M Y h:i A', strtotime($quiz_details['start_date_time']))); ?></p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card-new1  mt-5 p-4">
                            <p class="h6"><b>Duration (HH:MM)
                                    :</b><?php echo e($quiz_details['total_time']); ?></p>
                        </div>
                    </div>
                    <div class="col ">
                        <div class="">
                            <p class="h6">
                                <div class="counter-div">
                                00
                            </div></p>
                        </div>
                    </div>
                    <?php if($quiz_details['questions_category_details']!=''): ?>
                    <div class="col-md-10 p-4 pb-0">
                        <p class="text-justify"><b>Categories :</b>

                       <?php $__currentLoopData = $cat_timings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button class="btn btn-outline-primary"><?php echo e($category->category); ?> <?php echo e($category->qu_count); ?> <i class="ti ti-time fs-10"></i> <?php echo e($category->category_time); ?></button>
                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </p>
                    </div>
                    <?php endif; ?>
                    <div class="col-md-2 p-4 pb-0">
                        <a href="<?php echo e(url('/admin/quiz/attended/' . $quiz_details['id'])); ?>"
                            class="float-right btn btn-primary"> Attended Details</a>
                    </div>
                </div>
            <?php endif; ?>

        </div><?php ($totalMarks=0); ?>
        <?php $__currentLoopData = $quiz_details['quiz_detail']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $questions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php ($totalMarks+=$questions['question']['marks']); ?>
            <div class="row new-dash1 ">
                <div class="col-lg-1"></div>
                <div class="column col-xl-10 col-lg-12 col-md-12">

                    <div class="card p-4">
                        
                        

                        <div class="quiz-question mr-30">
                            <div class="mr-40"><?php echo e(sprintf('%02d', $loop->iteration) . '.'); ?></div>
                            <div class="question"><?php echo $questions['question']['question']; ?></div>
                        </div>
                        <div class="back-line"></div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row mt-3 ml-10">
                                    <?php ($alphabet = 'A'); ?>
                                    <?php for($i = 1; $i <= 6; $i++): ?>
                                        <?php if($questions['question']['answer' . $i]): ?>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                <?php ($right_answer = 'answer' . $i == $questions['question']['correct_answer'] ? 'right-answer' : ''); ?>

                                                <div class="quiz-answer <?php echo e($right_answer); ?>">
                                                    <div class="mr-20"><?php echo e($alphabet); ?>.</div>
                                                   <div> <?php echo $questions['question']['answer' . $i]; ?></div>
                                                </div>

                                            </div>

                                            <?php ($alphabet++); ?>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                    <hr class="question-details" />
                                    <div class="col-lg-12">
                                        <div class="pull-right">
                                            <span class="tag tag-blue mr-2 "> Marks
                                                (<?php echo e($questions['question']['marks']); ?>)</span>
                                            <?php if($questions['question']['negative_marking']): ?>
                                                <span class="tag tag-danger "> Negative Marking
                                                    (<?php echo e($questions['question']['negative_marking']); ?>)</span>
                                            <?php endif; ?>

                                        </div>
                                        <b>Description :</b><?php echo $questions['question']['description']; ?>

                                    </div>



                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <a class="fixed-bottom-right back-btn" href="<?php echo e($backUrl); ?>" style="width: 50px; height: 50px">
        <i class="fa fa-arrow-left fa-2x"></i>
    </a>



    <!-- MODAL For Quiz Details Edit-->
    <div id="quiz_description_modal" class="modal fade">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-header pd-x-20">
                    <h6 class="modal-title">Edit <?php echo e($quiz_details['type']); ?> Details</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php echo e(Form::open(['url' => 'admin/quiz/save', 'method' => 'POST', 'class' => 'validate-form', 'id' => ''])); ?>

                <?php echo e(Form::hidden('id', $quiz_details['id'])); ?>

                <?php echo e(Form::hidden('type', $quiz_details['type'])); ?>

                <?php echo e(Form::hidden('course_id', $quiz_details['course_id'])); ?>

                <?php echo e(Form::hidden('special_test_course_id', $quiz_details['course_id'])); ?>

                <div class="modal-body pd-20">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">

                                <div class="col-lg-12">
                                    <label class="form-label">Quiz Name</label>
                                    <div class="form-group">
                                        <?php echo e(Form::text('quiz_name', $quiz_details['quiz_name'], ['class' => 'form-control ','placeholder' => 'Title','required'])); ?>

                                    </div>
                                </div>
                                <?php if($quiz_details['type']==2 || $quiz_details['type']==4): ?>
                                <div class="col-lg-4">
                                    <label class="form-label"> Start Date</label>
                                    <div class="form-group">
                                        <?php echo e(Form::text('publish_date', date('d-m-Y', strtotime($quiz_details['publish_date'])), ['class' => 'form-control fc-datepicker','placeholder' => 'Publish Date','autocomplete' => 'off','required'])); ?>

                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <label class="form-label"> Start Time</label>
                                    <div class="form-group">
                                        <?php echo e(Form::time('start_time', date('H:i', strtotime($quiz_details['start_date_time'])), ['class' => 'form-control','placeholder' => 'Publish Date','autocomplete' => 'off','required'])); ?>

                                    </div>
                                </div>
                                <?php else: ?>
                                <div class="col-lg-4">
                                    <label class="form-label"> Publish Date</label>
                                    <div class="form-group">
                                        <?php echo e(Form::text('publish_date', date('d-m-Y', strtotime($quiz_details['publish_date'])), ['class' => 'form-control fc-datepicker','placeholder' => 'Publish Date','autocomplete' => 'off','required'])); ?>

                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="col-lg-4">
                                    <label class="form-label">Duration (HH:MM)</label>
                                    <div class="form-group">
                                        <?php echo e(Form::select('total_time', $times, $quiz_details['total_time'], ['class' => 'form-control select2','placeholder' => 'Total Time','required'])); ?>

                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label">Status</label>
                                    <div class="form-group">
                                        <?php echo e(Form::select('status', ['Active' => 'Active', 'InActive' => 'In-Active'], $quiz_details['status'], ['class' => 'form-control select2'])); ?>

                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <?php echo e(Form::textarea('description', $quiz_details['description'], ['class' => 'form-control form-input','rows' => '3','placeholder' => 'Description'])); ?>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <?php echo e(Form::submit('Update', ['class' => 'btn btn-primary'])); ?>

                </div>
                <?php echo e(Form::close()); ?>

            </div>
        </div><!-- MODAL DIALOG -->
    </div>
    <!-- Quiz Details Edit End -->



    <?php echo e(Html::script('js/dependent_check_out.js')); ?>

    <!-- Quiz Questions Edit Ends Here -->
<?php $__env->stopSection(); ?>
<?php $__env->startPush('includeJs'); ?>
<script>
    let totalMarks = '<?php echo e($totalMarks); ?>';
    $('.counter-div').html(totalMarks);
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.adminMain', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\91701\Downloads\gurudev\GurudevClone\resources\views/Quiz/adminQuizView.blade.php ENDPATH**/ ?>