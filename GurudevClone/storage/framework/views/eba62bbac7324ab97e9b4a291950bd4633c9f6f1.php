
<?php $__env->startSection('title','Course'); ?>
<?php $__env->startSection("content"); ?>
    <!-- Main content -->
    <?php ($backUrl='dashboard'); ?>
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="page-title">Course</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(url('/dashboard')); ?>"><i
                                            class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Courses</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="row match-height">
            <?php ($k=1); ?>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if ($k == 4) $k = 1; ?>
                <div class="col-lg-4 col-md-4 col-12">
                    <?php if($list->course_type=='Free'): ?>
                        <div class=" box ribbon-box column">
                            <div class="ribbon-two ribbon-two-success"><span>FREE</span></div>

                            <div class="box-header no-border p-0">
                                <a href="<?php echo e(url('/course/'.$list->slug)); ?>">
                                    <img class="img-fluid" src="<?php echo e(uploads($list->background_image)); ?>"
                                         onerror="this.src='<?php echo e(uploads('Uploads/Course/default/'.($k++).'.jpeg')); ?>'"
                                         alt="" style="height: 200px;">
                                </a>
                            </div>
                            <div class="box-body bt btr-0">
                                <div class="text-center">
                                    <h4 class="my-10"><a href="<?php echo e(url('/course/'.$list->slug)); ?>"><?php echo e($list->course); ?></a>
                                    </h4>
                                    <h4 class="pro-price mb-0 mt-20">₹ <?php echo e($list->final_amount); ?>

                                        <span class="old-price">₹ <?php echo e($list->amount); ?></span>
                                        <span class="badge badge-pill badge-warning-light"><?php echo e($list->discount); ?>% off</span>
                                    </h4>
                                </div>
                                <div class="clearfix text-center mt-10 ">

                                    <a  href="<?php echo e(url('/course/'.$list->slug)); ?>" class=" btn-sm waves-effect waves-light btn btn-danger-light"><i
                                                class="fa fa-unlock"></i> Free Course</a>
                                    <a  href="<?php echo e(url('/course/'.$list->slug)); ?>"
                                       class=" btn-sm  mt-0 waves-effect waves-light btn btn-primary-light "><i
                                                class="fa fa-check"></i> View Details</a>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="box ribbon-box column">
                            <div class="ribbon-two ribbon-two-primary"><span><?php echo e($list->course_type); ?></span></div>
                            <div class="box-header no-border p-0">
                                <a href="<?php echo e(url('/course/'.$list->slug)); ?>">
                                    <img class="img-fluid" src="<?php echo e(uploads($list->background_image)); ?>"
                                         onerror="this.src='<?php echo e(uploads('Uploads/Course/default/'.($key++).'.jpeg')); ?>'"
                                         alt="" style="height: 200px;object-fit: cover;">
                                </a>
                            </div>
                            <div class="box-body bt btr-0" chapterAmount="<?php echo e($list->final_amount); ?>" chapterName="<?php echo e($list->course); ?>" chapterId="<?php echo e($list->id); ?>">
                                <div class="text-center">
                                    <h4 class="my-10"><a href="<?php echo e(url('/course/'.$list->slug)); ?>"><?php echo e($list->course); ?></a>
                                    </h4>
                                    <h4 class="pro-price mb-0 mt-20">₹ <?php echo e($list->final_amount); ?>

                                        <span class="old-price">₹ <?php echo e($list->amount); ?></span>
                                        <span class="badge badge-pill badge-warning-light"><?php echo e($list->discount); ?>% off</span>
                                    </h4>
                                </div>
                                <div class="clearfix text-center mt-10 ">
                                    <?php if($list->payment->status=='Success'): ?>
                                    <a href="<?php echo e(url('/course/'.$list->slug)); ?>"  class="btn-sm waves-effect waves-light btn btn-success-light"><i class="fa fa-unlock"></i> Purchased</a>
                                    <?php else: ?>
                                        <a type="button"  class="not-purchase btn-sm waves-effect waves-light btn btn-danger-light"><i class="fa fa-lock"></i> Buy Course</a>
                                    <?php endif; ?>
                                        <a href="<?php echo e(url('/course/'.$list->slug)); ?>"
                                       class=" btn-sm  mt-0 waves-effect waves-light btn btn-primary-light "><i
                                                class="fa fa-check"></i> View Details</a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if($data->count()==0): ?>

                <div class="col-md-12 col-lg-12">
                    <div class="card ">

                        <div class="card-body text-center">
                            <img src="<?php echo e(URL::asset('user/images/404.jpg')); ?>" class=" align-self-center not-found-img" alt="branding logo"><br/>

                            <h3 class="font-large-2 my-1"> No Course Found!</h3>


                        </div>

                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('includeJs'); ?>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        $('.not-purchase').on('click',function () {
            let chapterName=$(this).parents('.box-body').attr('chapterName')
            let amount=($(this).parents('.box-body').attr('chapterAmount') )
            if(amount <= 0){
                alert('The amount must be greater than 0');
            }
            let course_id=$(this).parents('.box-body').attr('chapterId')
            $.ajax({
                method: 'post',
                url: "<?php echo e(url('/generatePaymentOrder')); ?>",
                data: {
                    "_token": "<?php echo e(csrf_token()); ?>",
                    "amount": amount
                },
                success: function (html) {
                    
                    var options = {
                        "key": "<?php echo e(env('RAZORPAY_KEY_ID')); ?>", // Enter the Key ID generated from the Dashboard
                        "amount": (amount * 100), // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                        "currency": "INR",
                        "name": chapterName,
                        "order_id": html, 
                        "handler": function (response) {     
                            if(response.razorpay_payment_id){
                                generatePaymentDetails(course_id,
                                                       html,
                                                       response.razorpay_payment_id,
                                                       response.razorpay_order_id,
                                                       response.razorpay_signature
                                                      );
                                function generatePaymentDetails(course_id,order_id,razorpay_payment_id,razorpay_order_id,razorpay_signature){
                                    $.ajax({
                                        method: 'post',
                                        url: "<?php echo e(url('/generatePayment')); ?>",
                                        data: {
                                            "_token": "<?php echo e(csrf_token()); ?>",
                                            "razorpay_payment_id": razorpay_payment_id,
                                            "razorpay_signature": razorpay_signature,
                                            "razorpay_order_id": razorpay_order_id,
                                            "course_id": course_id,
                                            "order_id": order_id,
                                            "type": 'Course',
                                        },
                                        success: function (response) {
                                            $('.preloader').addClass('disable')
                                            try {
                                                $('.modal-backdrop').remove()
                                                if (response.status == 'Success') {
                                                    swal({
                                                        html: true,
                                                        title: "<h3>Course Purchased Successfully</h3>",
                                                        text: "<table class='table table-bordered '>" +
                                                            "<tr><td>Amount :</td><td>" + response['amount'] + "</td><tr>" +
                                                            "<tr><td>Payment Id :</td><td>" + response['payment_id'] + "</td><tr>" +
                                                            "<tr><td>Payment Date :</td><td>" + response['payment_date'] + "</td><tr>" +
                                                            "<tr><td>Status :</td><td><b>" + response['status'] + "</b></td><tr>" +
                                                            "</table>",
                                                        type: "success"
                                                    }, function () {
                                                        location.reload();
                                                    });
                                                } else { 
                                                    swal({
                                                       html: true,
                                                       title: response,
                                                    });
                                                }
                                            } catch (err) {
                                                swal({
                                                       html: true,
                                                       title: response,
                                                    });
                                            }
                                        },
                                        error: function (response) {
                                            $('.loading').css('display', 'none')
                                            $('.modal-backdrop').remove()
                                            swal({
                                                html: true,
                                                title: "<h3>Payment Failed</h3>",
                                                text: JSON.stringify(response),
                                                type: "error"
                                            })
                                        }
                                    })
                                }
                            }
                            else{
                                swal({
                                    html: true,
                                    title: "<h3>Payment Failed</h3>",
                                    text: "please try later",
                                    type: "error"
                                })
                            }
                        },
                        "prefill": {
                            "name": '<?php echo e(Auth::user()->name); ?>',
                            "email": '<?php echo e(Auth::user()->email); ?>',
                            "contact": '<?php echo e(Auth::user()->mobile); ?>',
                        },
                        "notes": {
                            "address": "Razorpay Corporate Office"
                        },
                        "theme": {
                            "color": "#7367f0b3"
                        }
                    };
                    var r = new Razorpay(options);
                    r.open()
                },
                error: function (t) {
                   console.log(response);
                }
            });
        })
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.userMain', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\91701\Downloads\gurudev\GurudevClone\resources\views/User/course.blade.php ENDPATH**/ ?>