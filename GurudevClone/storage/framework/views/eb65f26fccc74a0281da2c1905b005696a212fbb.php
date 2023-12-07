<?php $__env->startSection("title","Test Series Course"); ?>
<?php $__env->startSection('content'); ?>
    <div class="row mt-30">
        <div class="col-md-4">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <h3 class="card-title">Test Series Course</h3>
                </div>
                <div class="card-body">
                    <?php echo e(Form::model($model,array('url'=>'/admin/specialTest/course', 'method' => 'post', 'files' => true))); ?>

                    <?php echo e(Form::hidden('id',null)); ?>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Course Name</label>
                                <?php echo e(Form::text('course',null,['class'=>'form-control required','placeholder'=>'Course Name','required'])); ?>

                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label>Course Type</label>
                            <div class="custom-controls-stacked mt-10">
                                <label class="custom-control custom-radio">
                                    <?php echo e(Form::radio('type', 'Paid', true, array('class'=>'custom-control-input','onclick'=>"changeCourseType('Paid')"))); ?>

                                    <span class="custom-control-label">Paid</span>
                                </label>
                                <label class="custom-control custom-radio">
                                    <?php echo e(Form::radio('type', 'Free', false, array('class'=>'custom-control-input ','onclick'=>"changeCourseType('Free')"))); ?>

                                    <span class="custom-control-label">Free</span>
                                </label>
                                <label class="custom-control custom-radio">
                                    <?php echo e(Form::radio('type', 'Upcoming', false, array('class'=>'custom-control-input ','onclick'=>"changeCourseType('Free')"))); ?>

                                    <span class="custom-control-label">Upcoming</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Course Amount</label>
                                <?php echo e(Form::text('amount',null,['class'=>'form-control isNumber required courseAmount','placeholder'=>'Course Amount','autocomplete'=>'off','required'])); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <?php echo $__env->make('includes.save_update_button', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <?php echo e(Form::close()); ?>

            </div>
        </div>
        <div class="col-md-8">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <h3 class="card-title">Test Series Course</h3>
                    <div class="card-options">
                        <div class="pull-right">
                            <a href="<?php echo e(url('admin/specialTest/test/list')); ?>" class="btn btn-primary btn-icon text-white mr-2">
                                <span><i class="fe fe-plus"></i></span> Add Test
                            </a>

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="current_affairs" class="table table-striped table-bordered w-100">
                            <thead class="bg-blue">
                            <tr>
                                <th>#</th>
                                <th>Course</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $table_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $array): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e((($table_list->currentPage()-1)*$table_list->perPage())+$loop->iteration); ?></td>
                                    <td> <?php echo e($array['course']); ?>    </td>
                                    <td> <?php echo e($array['type']); ?>    </td>
                                    <td> <?php echo e($array['amount']); ?>    </td>
                                    <td class="text-nowrap">
                                        <a href="<?php echo e(route('specialTestCourse',['id'=>$array['id']])); ?>"
                                           class="table_icons" data-toggle="tooltip" data-original-title="Edit"><i
                                                    class="ti ti-pencil" aria-hidden="true"></i></a>
                                        <a href="<?php echo e(route('dynamicDelete',['modal'=>'SpecialTestCourse','id'=>$array['id']])); ?>"
                                           class="table_icons confirm-delete" data-toggle="tooltip"
                                           data-original-title="Delete"><i class="ti ti-trash"
                                                                           aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        <?php echo $table_list->links(); ?>

                    </div>

                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('includeJs'); ?>
    <?php echo $__env->make('includes.CssJs.advanced_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('includes.CssJs.dataTable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script>
        let courseType = '<?php echo e($model['type']); ?>'
        if (courseType !== '') changeCourseType(courseType);

        function changeCourseType(type) {
            if (type === 'Free') {
                $('.courseAmount').attr('readonly', true)
                $('.courseAmount').val(0)
            } else {
                $("input[name=amount]").removeAttr('readonly', true)
            }

        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.adminMain', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\91701\Downloads\gurudev\GurudevClone\resources\views/Setting/adminSpecialTestCourse.blade.php ENDPATH**/ ?>