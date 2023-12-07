<style>
    .header-desktop {
        background: url('<?php echo e(asset('user/images/logo-dark-text.png')); ?>');
        display: block;
        position: absolute;
        width: 250px;
        height: 40px;
        background-repeat: no-repeat;
        margin-top: 0;
    }
</style>
<div class="page-main1">
    <div class="header app-header">
        <div class="container-fluid">
            <div class="d-flex header-nav">
                <a href="#" data-toggle="sidebar" class="nav-link icon toggle"><i class="fe fe-align-justify"></i></a>
                <div class="color-headerlogo">
                    <a class="header-desktop" href="<?php echo e(url('/admin/dashboard')); ?>"></a>
                    <a class="header-mobile" href="<?php echo e(url('/admin/dashboard')); ?>"></a>
                </div><!-- Color LOGO -->


                <div class="d-flex order-lg-2 ml-auto header-right-icons header-search-icon">
                    <!--	<div class="dropdown  search-icon">
                            <a href="#" data-toggle="search" class="nav-link nav-link-lg d-md-none navsearch">
                                <i class="fe fe-search"></i>
                            </a>
                        </div>-->
                    <div class="dropdown  header-fullscreen">
                        <a class="nav-link icon full-screen-link nav-link-bg" id="fullscreen-button">
                            <i class="fe fe-minimize" ></i>
                        </a>
                    </div><!-- FULL-SCREEN -->


				
				
                    <div class="dropdown header-user">
                        <a href="#" class="nav-link icon" data-toggle="dropdown" style="display: inline-flex;">
                            <h5 class="hidden-hedder-mobile mr-20"><?php echo e(Auth::guard('admin')->user()->name); ?> </h5>
                            <span><img src="<?php echo e(uploads('Uploads/default.png')); ?>" alt="profile-user" class="avatar brround cover-image mb-0 ml-0"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <div class=" dropdown-header noti-title text-center border-bottom p-3">
                                <div class="header-usertext">
                                    <h5 class="mb-1"><?php echo e(Auth::guard('admin')->user()->name); ?></h5>
                                    <p class="mb-0"><?php echo e(Session::get('department')); ?></p>
                                    <p class="mb-0"><?php echo e(Session::get('designation')); ?></p>
                                </div>
                            </div>
                            
                            <a class="dropdown-item" href="<?php echo e(url('/admin/changePassword')); ?>">
                                <i class="mdi mdi-lock mr-2"></i> <span> Change Password</span>
                            </a>
                            
                            <a class="dropdown-item" href="<?php echo e(url('/admin/logout')); ?>">
                                <i class="mdi  mdi-logout-variant mr-2"></i> <span>Logout</span>
                            </a>
                        </div>
                    </div><!-- SIDE-MENU -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function setOngoingYear(id) {
        $('#global-loader').css('display','');
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            data: {'id' : id},
            url: '<?php echo e(url('setOngoingYear/')); ?>',
            dataType: 'json',
            success: function (html) {
                location.reload();
            },
            error: function (html) {
                console.log(html)
            }
        });
    }
</script><?php /**PATH C:\Users\91701\Downloads\gurudev\GurudevClone\resources\views/includes/admin_header.blade.php ENDPATH**/ ?>