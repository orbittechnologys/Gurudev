<html>
<head>
    <?php echo $__env->make('includes.meta', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    <link href="<?php echo e(asset('assets/css/style.css')); ?>" rel="stylesheet"/>
    <link href="<?php echo e(asset('assets/css/color-skins/color1.css')); ?>" rel="stylesheet"/>
    <link href="<?php echo e(asset('assets/css/skins-modes.css')); ?>" rel="stylesheet"/>

    <!--SIDEMENU CSS-->
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/sidemenu/sidemenu.css')); ?>">

    <!--SIDEMENU-RESPONSIVE-TABS  css -->
    <link href="<?php echo e(asset('assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css')); ?>" rel="stylesheet">

    <!-- TABS CSS -->
    <link href="<?php echo e(asset('assets/plugins/tabs/tabs-2.css')); ?>" rel="stylesheet" type="text/css">

    <!-- P-SCROll CSS -->
    <link href="<?php echo e(asset('assets/plugins/p-scroll/p-scroll.css')); ?>" rel="stylesheet" type="text/css">

    <!--- FONT-ICONS CSS -->
    <link href="<?php echo e(asset('assets/css/icons.css')); ?>" rel="stylesheet"/>

    <!-- SIDEBAR CSS -->
    <link href="<?php echo e(asset('assets/plugins/right-sidebar/right-sidebar.css')); ?>" rel="stylesheet">

    <!-- CUSTOM CSS -->
    <link href="<?php echo e(asset('assets/css/custom.css')); ?>" rel="stylesheet">

    <!--- Margin Padding Css -->
    <link href="<?php echo e(asset('assets/css/custom-bootstrap-margin-padding.css')); ?>" rel="stylesheet">



    <!--Date Range Picker CSS -->
    <link href="<?php echo e(asset('assets/plugins/daterangepicker-master/daterangepicker.css')); ?>" rel="stylesheet">

    <?php echo Html::style('assets/plugins/sweet-alert/sweetalert.css'); ?>

<!-- JQUERY SCRIPTS JS-->
    <script src="<?php echo e(asset('assets/js/vendors/jquery-3.2.1.min.js')); ?>"></script>

    <?php echo $__env->yieldPushContent('includeCss'); ?>
</head>

<body class="app">

<!-- GLOBAL-LOADER -->
<div id="global-loader">
    <img src="<?php echo e(asset('/assets/images/svgs/loader.svg')); ?>" class="loader-img" alt="Loader">
</div>
<div  id="ajxloader">
    <div>Processing...</div>
</div>
<div class='notify-alert alert  col-xl-3 col-lg-3 col-md-3 col-12 animated fadeInDown php-alert'  id='php-alert'>
    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><span class="alert-message"></span>
</div>

<div class="page">
    <!-- HEADER -->
<?php echo $__env->make('includes.admin_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldPushContent('includeCss'); ?>
<!-- HEADER END -->

    <!-- Sidebar menu-->
<?php echo $__env->make('includes.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!--sidemenu end-->

    <!-- CONTAINER -->
    <div class=" app-content">
        <div class="section">
            
            <span id="getNextChild" style="display: none"><?php echo e(url('getNextChild')); ?></span>
            <span id="addNewMaster" style="display: none"><?php echo e(url('addNewMaster')); ?></span>
            <span id="appPath" style="display: none"><?php echo e(url('')); ?></span>
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
</div>
<footer class="footer left-footer" style="margin-top:50px;">
    <div class="container">
        <div class="row align-items-center flex-row-reverse">
            <div class="col-md-12 col-sm-12 ">
                Copyright © 2021 <a href="#">Gurudev Academy</a>. Powered by <a href="http://stepintechnology.com/" target="_blank">Step In Technologies </a> All rights reserved.
            </div>
        </div>
    </div>
</footer>


<!-- FOOTER CLOSED -->

<?php echo $__env->make('includes.CssJs.flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldPushContent('includeJs'); ?>
<!-- BACK-TO-TOP -->
<a href="#top" id="back-to-top"><i class="fa fa-angle-double-up"></i></a>

<!-- BOOTSTRAP SCRIPTS JS -->
<script src="<?php echo e(asset('assets/js/vendors/bootstrap.bundle.min.js')); ?>"></script>

<!-- SPARKLINE -->
<script src="<?php echo e(asset('assets/js/vendors/jquery.sparkline.min.js')); ?>"></script>

<!-- INPUT MASK JS-->
<script src="<?php echo e(asset('assets/plugins/input-mask/input-mask.min.js')); ?>"></script>

<!-- SIDEBAR JS -->
<script src="<?php echo e(asset('assets/plugins/right-sidebar/right-sidebar.js')); ?>"></script>

<!-- P-SCROLL JS -->
<script src="<?php echo e(asset('assets/plugins/p-scroll/p-scroll.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/p-scroll/p-scroll-leftmenu.js')); ?>"></script>

<!--SIDEMENU JS-->
<script src="<?php echo e(asset('assets/plugins/sidemenu/sidemenu.js')); ?>"></script>

<!-- SIDEMENU-RESPONSIVE-TABS JS-->
<script src="<?php echo e(asset('assets/plugins/sidemenu-responsive-tabs/js/sidemenu-responsive-tabs.js')); ?>"></script>

<!--LEFT-MENU JS-->
<script src="<?php echo e(asset('assets/js/left-menu.js')); ?>"></script>

<!--Date Range Picker JS-->
<?php echo Html::script('assets/plugins/daterangepicker-master/moment.min.js'); ?>

<?php echo Html::script('assets/plugins/daterangepicker-master/daterangepicker.js'); ?>


<!--CUSTOM JS -->
<script src="<?php echo e(asset('assets/js/custom.js')); ?>"></script>

<?php echo Html::script('js/custom.js'); ?>

<!-- Validation JS -->

<script src="<?php echo e(asset('js/validation.js')); ?>"></script>

<?php echo Html::script('js/dependent_check_out_larvela.js'); ?>


<?php echo Html::script('assets/plugins/sweet-alert/sweetalert.min.js'); ?>

<?php echo Html::script('assets/js/sweet-alert.js'); ?>


</body>
</html><?php /**PATH C:\Users\91701\Downloads\gurudev\GurudevClone\resources\views/layout/adminMain.blade.php ENDPATH**/ ?>