<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar position-relative">
        <div class="multinav">
            <div class="multinav-scroll" style="height: 93%;">
                <!-- sidebar menu-->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="{{ request()->is('dashboard') ? 'active' : '' }}"> <a href="{{url('/dashboard')}}"> <i class="fa fa-home"></i> <span>Home</span>  </a></li>
                    <li class="{{ (request()->is('course') || request()->is('course/*')) ? 'active' : '' }}"> <a href="{{url('/course')}}"> <i class="fa fa-cubes"></i> <span>Course</span> </a> </li>
                    <li class="{{ (request()->is('currentAffairs') || request()->is('currentAffairs/*')) ? 'active' : '' }}"> <a href="{{url('/currentAffairs/')}}">  <i class="fa fa fa-newspaper-o"></i><span>Current Affairs</span>   </a> </li>
                    <li class="{{ (request()->is('mcq') || request()->is('mcq/*')) ? 'active' : '' }}"> <a href="{{url('/mcq')}}"> <i class="fa fa-anchor"></i> <span>Daily MCQs</span></a>   </li>
                    <li class="{{ ( request()->is('specialTest/*') || request()->is('specialTest')) ? 'active' : '' }}"> <a href="{{url('/specialTest/course')}}">   <i class="fa fa-archive"></i>    <span>Test Series</span>   </a> </li>
                    <li class="{{ (request()->is('studyMaterials')) ? 'active' : '' }}"> <a href="{{url('/studyMaterials')}}">    <i class="fa fa-paper-plane-o"></i>  <span>Study Material</span>  </a> </li>
                    <li class="{{ request()->is('videoMaterials') ? 'active' : '' }}"> <a href="{{url('/videoMaterials')}}">  <i class="fa fa-video-camera"></i>   <span>Videos</span>  </a> </li>
                    <li class="{{ request()->is('liveClass') ? 'active' : '' }}"> <a href="{{url('/liveClass')}}">  <i class="fa fa-file-video-o"></i>   <span>Live Class</span>  </a> </li>
                    <li class="{{ request()->is('bookmarks') ? 'active' : '' }}"> <a href="{{url('/bookmarks')}}">  <i class="fa fa-bookmark"></i>   <span>Bookmarks</span>  </a> </li>
                     <li class="{{ request()->is('weeklyBuzz/*') ? 'active' : '' }}"> <a href="{{url('/weeklyBuzz/folder')}}">  <i class="fa fa-newspaper-o"></i>   <span>E Magazine</span>  </a> </li>
                      <!--<li class="{{ request()->is('youtubeVideos') ? 'active' : '' }}"> <a href="{{url('/youtubeVideos')}}">  <i class="fa fa-youtube"></i>   <span>Youtube Videos</span>  </a> </li>-->
                </ul>
            </div>
          <div class="sidebar-footer sidebar-footer2">
                <a href="javascript:void(0)" class="link" data-toggle="tooltip" title=""
                    data-original-title="Facebook" aria-describedby="tooltip92529"><span
                        class="fa fa-facebook"></span></a>
                <a href="javascript:void(0)" class="link text-success" data-toggle="tooltip" title=""
                    data-original-title="Whatsapp"><span class="fa fa-whatsapp"></span></a>
                <a href="javascript:void(0)" class="link text-info" data-toggle="tooltip" title=""
                    data-original-title="twitter"><span class="fa fa-twitter"><span
                            class="path1"></span><span class="path2"></span></span></a>
            </div>
            <div class="sidebar-footer sidebar-footer1">
                <a href="{{ url('/logout') }}"  data-toggle="tooltip" title=""
                    data-original-title="Logout" aria-describedby="tooltip92529"><i class="fa fa-sign-out"></i>
                    <span>Logout</span> </a>
            </div>
        </div>
    </section>

</aside>
