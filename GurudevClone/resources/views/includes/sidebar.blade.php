<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="side-tab-body p-0 border-0" id="sidemenu-Tab">
        <div class="first-sidemenu ps ps--active-y">
            <ul class="resp-tabs-list hor_1">
                @foreach($userRoleMainMenu as $mainMenu)
                    @if(sizeof($mainMenu['sub_module'])>1)
                        <li class="MainMenu "><i class="{{ $mainMenu['icon_name'] }}"></i><span class="side-menu__label">{{ $mainMenu['module_name'] }}</span></li>
                    @else
                        <a href="{{ url($mainMenu['sub_module'][0]['url']) }}">
                            <li class="text-white">
                                <i class="{{ $mainMenu['icon_name'] }}"></i>
                                <span class="side-menu__label">{!! $mainMenu['module_name']!!}</span>
                            </li>
                        </a>
                    @endif
                @endforeach
            </ul>
        </div>
        <div class="second-sidemenu">
            <div class="resp-tabs-container hor_1">
                <?php //print_r($userRoleMainMenu); ?>
                @foreach($userRoleMainMenu as $mainMenu)
                    @if(sizeof($mainMenu['sub_module'])>1) <?php //print_r($mainMenu); ?>
                    <div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel sidetab-menu">
                                    <div class="panel-body tabs-menu-body p-0 border-0">
                                        <div class="tab-content">
                                            <div class="tab-pane active " id="side61">
                                                <h5 class="mt-3 mb-4">{{$mainMenu['module_name']}}</h5>
                                                @foreach ($mainMenu['sub_module'] as $submenu)

                                                    @if($submenu['url']!='' && $submenu['level']=='Level1')

                                                        <a href="{{url($submenu['url'])}}" class="slide-item"> {!! $submenu['sub_module_name'] !!}</a>

                                                    @elseif($submenu['url']=='')

                                                        <div class="side-menu p-0">
                                                            <div class="slide submenu">
                                                                <a class="side-menu__item" data-toggle="slide" href="#"><span class="side-menu__label">{{ $submenu['sub_module_name'] }}</span><i class="angle fa fa-angle-down"></i></a>
                                                                <ul class="slide-menu submenu-list">

                                                                    @foreach($mainMenu['sub_module'] as $secondLevel)
                                                                        @if($secondLevel['level']=='Level2' && $secondLevel['under']==$submenu['id'] && $secondLevel['url']!='')
                                                                            <li><a href="{{url($secondLevel['url'])}}" class="slide-item">{{ $secondLevel['sub_module_name'] }}</a></li>
                                                                        @endif
                                                                    @endforeach

                                                                </ul>
                                                            </div>
                                                        </div>

                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                        <div></div>
                    @endif

                @endforeach
            </div>
        </div>

    </div>
</aside>
<!--sidemenu end-->