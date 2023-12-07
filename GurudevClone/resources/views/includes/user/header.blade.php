<header class="main-header">
    <div class="d-flex align-items-center logo-box justify-content-start">
        <a href="#" class="waves-effect waves-light nav-link d-none d-md-inline-block mx-10 push-btn bg-transparent"
           data-toggle="push-menu" role="button">
            <span class="icon-Align-left"><span class="path1"></span><span class="path2"></span><span
                        class="path3"></span></span>
        </a>
        <!-- Logo -->
        <a href="{{url('/dashboard')}}" class="logo">
            <!-- logo-->
            <div class="logo-lg">
                <span class="light-logo"><img src="{{asset('/user/images/logo-dark-text.png')}}" alt="logo"></span>
                <span class="dark-logo"><img src="{{asset('/user/images/logo-dark-text.png')}}" alt="logo"></span>
            </div>
        </a>
    </div>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <div class="app-menu">
            <ul class="header-megamenu nav">
                <li class="btn-group nav-item d-none d-xl-inline-block">
                    <a href="{{url('bookmarks')}}" class="waves-effect waves-light nav-link svg-bt-icon" title="Bookmarks">
                        <i class="fa fa-bookmark"><span class="path1"></span><span class="path2"></span></i>
                    </a>
                </li>
            </ul>
        </div>

        <div class="navbar-custom-menu r-side">
            <ul class="nav navbar-nav">
                <li class="btn-group nav-item d-lg-inline-flex d-none">
                    <a href="#" data-provide="fullscreen" class="waves-effect waves-light nav-link full-screen"
                       title="Full Screen">
                        <i class="icon-Expand-arrows"><span class="path1"></span><span class="path2"></span></i>
                    </a>
                </li>

                <li class="dropdown notifications-menu">
                    <a href="#" class="waves-effect waves-light dropdown-toggle" data-toggle="dropdown"
                       title="Notifications">
                        <i class="icon-Notifications"><span class="path1"></span><span class="path2"></span></i>
                    </a>
                    <ul class="dropdown-menu animated bounceIn">

                        <li class="header">
                            <div class="p-20">
                                <div class="flexbox">
                                    <div>
                                        <h4 class="mb-0 mt-0">Announcements</h4>
                                    </div>

                                </div>
                            </div>
                        </li>

                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu sm-scrol">
                                <?php $announcement=$notifications ?>
                                @foreach($announcement as $list)
                                    <?php if($list->attachment!='') $list['attachment']=uploads($list->attachment); ?>
                                    <?php if($list->pdf!='') $list['pdf']=uploads($list->pdf); ?>
                                        <li class="announcementReadMore"  data-content="{{$list}}" >
                                            <a href="javascript:void(0)"  >
                                                <i class="fa fa-newspaper-o text-{{$colors[$loop->iteration]}}"></i>{{$list->title}}
                                            </a>
                                        </li>
                                @endforeach
                                @if($announcement->count()==0)
                                        <li>
                                            <a href="#"  data-target="#modal-announcement"  data-toggle="modal" >
                                                <i class="fa fa-user text-success"></i> No Announcements
                                            </a>
                                        </li>
                                    @endif
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="{{url('/announcements')}}">View all</a>
                        </li>
                    </ul>
                </li>

                <!-- User Account-->
                <li class="dropdown user user-menu">
                    <a href="#" class="waves-effect waves-light dropdown-toggle" data-toggle="dropdown" title="User">
                        <i class="icon-User"><span class="path1"></span><span class="path2"></span></i>
                    </a>
                    <ul class="dropdown-menu animated flipInX">
                        <li class="user-body">
                           <a class="dropdown-item" href="#"><i class="ti-user text-muted mr-2"></i> {{Auth::user()->name}}</a>
                            <a class="dropdown-item" href="{{url('resetUserPassword')}}"><i class="ti-settings text-muted mr-2"></i>Change Password</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{url('/logout')}}"><i class="ti-lock text-muted mr-2"></i> Logout</a>
                        </li>
                    </ul>
                </li>
                <li class="btn-group nav-item d-lg-inline-flex d-none">
                    <a href="{{url('/logout')}}" data-provide="logout" class="waves-effect waves-light nav-link full-screen"
                       title="Logout">
                        <i class="fa fa-sign-out"><span class="path1"></span><span class="path2"></span></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>