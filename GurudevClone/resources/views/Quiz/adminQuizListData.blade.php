@if(sizeof($quiz_details['data'])>0)
<style>
    .delete_btn{
        position: absolute;
    z-index: 2;
    right: 15px;
    top: 23px;
    }
</style>
    <div class="row">
        @foreach($quiz_details['data'] as $quiz)
            @if($rand==3)
                @php ($rand=0)
            @endif
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                <div class="fs-12 text-muted delete_btn">
                    <a href="javascript:void(0)" id="{{$quiz['id']}}" data-page="{{$quiz_details['current_page']}}" class="confirm-delete_quiz" data-toggle="tooltip"
                       data-original-title="Delete">
                        <i class="ti ti-trash text-danger font-16" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="card" style="height: 180px">
                    <div class="card-header pt-2 pb-0 border-bottom-0 cursor-pointer">
                        <h6 class="mb-0" onclick="quiz_detail({{ $quiz['id'] }})"
                            style="cursor: pointer">{{ $quiz['quiz_name'] }}</h6>
                        <div class="card-options mt-3 mr-1 text-nowrap">
                            <h4>
                                <i class="fe fe-clock fs-15 text-{{ $main_color[$rand] }}"></i> {{ $quiz['total_time'] }}
                            </h4>
                        </div>
                    </div>
                    <div class="card-body pb-4">
                        <div class="row">
                            <div class="col-sm-5">
                                <div class=" mb-2 " onclick="quiz_detail({{ $quiz['id'] }})" style="cursor: pointer">
                                    <div class="number-font timing-font cursor-pointer">{{ $quiz['total_questions'] }}</div>
                                    <div class="fs-12 text-muted cursor-pointer"><span
                                                class="text-{{ $sub_color[$rand] }} ml-1">Questions</span></div>
                                </div>
                            </div>


                            <div class="col-sm-7">
                                <div class=" mb-2 pull-right"
                                     @if( $quiz['attempt_count'] != 0 ) onclick="quiz_attended({{ $quiz['id'] }})"
                                     @endIf style="cursor: pointer">
                                    <div class="number-font timing-font cursor-pointer text-right">{{ ($quiz['attempt_count']) }}</div>
                                    <div class="fs-12 text-muted cursor-pointer"><span
                                                class="text-{{ $sub_color[$rand] }} ml-1">Attended</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="progress h-1 mb-0">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-{{ $main_color[$rand] }} w-60"
                                 role="progressbar"></div>
                        </div>
                        <div class="mt-2 pull-left">
                            @if($quiz['status']=='Active')
                                <span class="badge badge-pill badge-success-gradient mr-1 mb-1 mt-1">Active</span>
                            @else
                                <span class="badge badge-pill badge-warning-gradient mr-1 mb-1 mt-1">In-Active</span>
                            @endif
                        </div>
                        <div class="mt-4 pull-right">
                                <span class="fs-12 text-muted">
                                    Published on  <span
                                            class="text-{{ $main_color[$rand] }} ml-1">{{ date('d M Y',strtotime($quiz['publish_date'])) }}</span>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
            @php( $rand++ )
        @endforeach
    </div>
    <div class="row mb-30">
        <div class="col-lg-12">
            <div class="mb-5">
                <ul class="pagination" style=" width: 300px; margin: auto;">
                    <li class="page-item page-prev {{ ($quiz_details['current_page']==1) ? 'disabled' : '' }}">
                        <a class="page-link" href="javascript:void(0);"
                           onclick="myPagination('{{ $quiz_details['prev_page_url']}}','full_url')"
                           tabindex="-1">Previous</a>
                    </li>

                    @for($i=1;$i<=$quiz_details['last_page'];$i++)

                        @if($quiz_details['current_page']<=4)
                            <li class="page-item {{ ($i==$quiz_details['current_page']) ? 'active' : '' }}"><a
                                        class="page-link" href="javascript:void(0)"
                                        onclick="myPagination({{ $i }})">{{ $i }}</a></li>
                        @endif


                        @if($i>=5)
                            @if($quiz_details['current_page']>=5)
                                <li class="page-item {{ (1==$quiz_details['current_page']) ? 'active' : '' }}"><a
                                            class="page-link" href="javascript:void(0)"
                                            onclick="myPagination(1)">{{ 1 }}</a></li>
                                <li class="page-item"><a class="page-link" style="cursor: default;">...</a></li>
                                <li class="page-item {{ ($quiz_details['current_page']-1==$quiz_details['current_page']) ? 'active' : '' }}">
                                    <a class="page-link" href="javascript:void(0)"
                                       onclick="myPagination({{ $quiz_details['current_page']-1 }})">{{ $quiz_details['current_page']-1 }}</a>
                                </li>
                                <li class="page-item {{ ($quiz_details['current_page']==$quiz_details['current_page']) ? 'active' : '' }}">
                                    <a class="page-link" href="javascript:void(0)"
                                       onclick="myPagination({{ $quiz_details['current_page'] }})">{{ $quiz_details['current_page'] }}</a>
                                </li>
                                @if(($quiz_details['current_page']+1)<$quiz_details['last_page'])
                                    <li class="page-item {{ ($quiz_details['current_page']+1==$quiz_details['current_page']) ? 'active' : '' }}">
                                        <a class="page-link" href="javascript:void(0)"
                                           onclick="myPagination({{ $quiz_details['current_page']+1 }})">{{ $quiz_details['current_page']+1 }}</a>
                                    </li>
                                @endif
                            @endif

                            @if($quiz_details['current_page']!=$quiz_details['last_page'] && ($quiz_details['current_page']+1)!=$quiz_details['last_page'])
                                <li class="page-item"><a class="page-link" style="cursor: default;">...</a></li>
                                <li class="page-item {{ ($quiz_details['last_page']==$quiz_details['current_page']) ? 'active' : '' }}">
                                    <a class="page-link" href="javascript:void(0)"
                                       onclick="myPagination({{ $quiz_details['last_page'] }})">{{ $quiz_details['last_page'] }}</a>
                                </li>
                            @endif
                            @break
                        @endif
                    @endfor
                    <li class="page-item page-next {{ ($quiz_details['current_page']==$quiz_details['last_page']) ? 'disabled' : '' }}">
                        <a class="page-link" href="javascript:void(0)"
                           onclick="myPagination('{{ $quiz_details['next_page_url'] }}', 'full_url')">Next</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@else
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card auth-card bg-transparent shadow-none rounded-0 mb-0 w-100">
                <div class="card-content">
                    <div class="card-body text-center">
                        <img src="{{ URL::asset('user/images/404.jpg')}}" class="img-fluid align-self-center not-found-img" alt="branding logo"><br/>

                        <h1 class="font-large-2 my-1"> No Record Found!</h1>


                    </div>
                </div>
            </div>
        </div>
        @endif
        <script>$('.my-loader').css('display','none')</script>   </div>
