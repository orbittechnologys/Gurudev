<section id="number-tabs">
    @if (!empty($questions['data']))
        <div class="row  mt-30">
            <div class=" col-lg-12 col-12">
                @foreach ($questions['data'] as $key => $question)
                    <div class="row new-dash1">
                        <div class="col-lg-1"></div>
                        <div class="column col-xl-10 col-lg-12 col-md-12">
                            <div class="card p-4 ">

                                @if (empty($question['question_allocation_detail']))
                                    <div class="item-action dropdown float-right-2">
                                        <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i
                                                class="fe fe-more-vertical"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="javascript:void(0)" class="dropdown-item"
                                                onclick="getQuestion({{ $question['id'] }})" data-toggle="tooltip"
                                                data-original-title="Edit"><i
                                                    class="dropdown-icon fa fa-pencil text-primary"></i> Edit </a>
                                            <a href="{{ route('dynamicDelete', ['modal' => 'Question', 'id' => $question['id']]) }}"
                                                class="dropdown-item confirm-delete" data-toggle="tooltip"
                                                data-original-title="Delete"><i
                                                    class="dropdown-icon fa fa-trash text-danger"></i> Delete </a>
                                        </div>
                                    </div>
                                @endif
                                <div class="quiz-question mr-20">
                                    <div
                                        class="mr-40">{{ ($questions['current_page'] - 1) * $questions['per_page'] + $loop->iteration . '.' }}{{-- {{$question['id']}} --}}</div>
                                   <div> <span class="question">{!! $question['question'] !!}</span></div>
                                </div>
                                <div class="back-line"></div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row mt-3 ml-10">
                                            @php($alphabet = 'A')
                                            @for ($i = 1; $i <= 6; $i++)
                                                @if ($question['answer' . $i])
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                        @php($right_answer = 'answer' . $i == $question['correct_answer'] ? 'right-answer' : '')

                                                        <div class="quiz-answer {{ $right_answer }}">
                                                            <div class="mr-30">{{ $alphabet }}.</div>
                                                          <div>  {!! $question['answer' . $i] !!}</div>
                                                        </div>
                                                    </div>
                                                    @php($alphabet++)
                                                @endif
                                            @endfor
                                            {{-- right-answer --}}
                                            <hr class="question-details" />
                                            <div class="w-100">
                                                @foreach (explode(',', $question['tags']) as $tags)
                                                    <span class="tag tag-gray-dark mr-2"> {{ $tags }}</span>
                                                @endforeach

                                                @if ($question['negative_marking'] > 0)
                                                    <span class="tag tag-danger mr-2 float-right"> Negative Marking
                                                        ({{ $question['negative_marking'] }})</span>
                                                @endif
                                                <span class="tag tag-blue mr-2 float-right"> Marks
                                                    ({{ $question['marks'] }})</span>

                                            </div>
                                            <br />
                                            <div> <b>Description :</b>{!! $question['description'] !!}</div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
        <div class="row mb-30">
            <div class="col-lg-12">
                <div class="mb-5">
                    <ul class="pagination" style=" width: 300px; margin: auto;">
                        <li class="page-item page-prev {{ $questions['current_page'] == 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="javascript:void(0);"
                                onclick="myPagination('{{ $questions['prev_page_url'] }}','full_url')"
                                tabindex="-1">Previous</a>
                        </li>

                        @for ($i = 1; $i <= $questions['last_page']; $i++)

                            @if ($questions['current_page'] <= 4)
                                <li class="page-item {{ $i == $questions['current_page'] ? 'active' : '' }}"><a
                                        class="page-link" href="javascript:void(0)"
                                        onclick="myPagination({{ $i }})">{{ $i }}</a></li>
                            @endif


                            @if ($i >= 5)
                                @if ($questions['current_page'] >= 5)
                                    <li class="page-item {{ 1 == $questions['current_page'] ? 'active' : '' }}"><a
                                            class="page-link" href="javascript:void(0)"
                                            onclick="myPagination(1)">{{ 1 }}</a></li>
                                    <li class="page-item"><a class="page-link"
                                            style="cursor: default;">...</a></li>
                                    <li
                                        class="page-item {{ $questions['current_page'] - 1 == $questions['current_page'] ? 'active' : '' }}">
                                        <a class="page-link" href="javascript:void(0)"
                                            onclick="myPagination({{ $questions['current_page'] - 1 }})">{{ $questions['current_page'] - 1 }}</a>
                                    </li>
                                    <li
                                        class="page-item {{ $questions['current_page'] == $questions['current_page'] ? 'active' : '' }}">
                                        <a class="page-link" href="javascript:void(0)"
                                            onclick="myPagination({{ $questions['current_page'] }})">{{ $questions['current_page'] }}</a>
                                    </li>
                                    @if ($questions['current_page'] + 1 < $questions['last_page'])
                                        <li
                                            class="page-item {{ $questions['current_page'] + 1 == $questions['current_page'] ? 'active' : '' }}">
                                            <a class="page-link" href="javascript:void(0)"
                                                onclick="myPagination({{ $questions['current_page'] + 1 }})">{{ $questions['current_page'] + 1 }}</a>
                                        </li>
                                    @endif
                                @endif

                                @if ($questions['current_page'] != $questions['last_page'] && $questions['current_page'] + 1 != $questions['last_page'])
                                    <li class="page-item"><a class="page-link"
                                            style="cursor: default;">...</a></li>
                                    <li
                                        class="page-item {{ $questions['last_page'] == $questions['current_page'] ? 'active' : '' }}">
                                        <a class="page-link" href="javascript:void(0)"
                                            onclick="myPagination({{ $questions['last_page'] }})">{{ $questions['last_page'] }}</a>
                                    </li>
                                @endif
                            @break
                        @endif
    @endfor
    <li class="page-item page-next {{ $questions['current_page'] == $questions['last_page'] ? 'disabled' : '' }}">
        <a class="page-link" href="javascript:void(0)"
            onclick="myPagination('{{ $questions['next_page_url'] }}', 'full_url')">Next</a>
    </li>
    </ul>
    </div>
    </div>
    </div>
@else
    <div class="col-md-12 col-lg-12">
        <div class="card auth-card bg-transparent shadow-none rounded-0 mt-50 w-100">
            <div class="card-content">
                <div class="card-body text-center">
                    <div class="mb-30 mt-20">
                        <img src="{{ URL::asset('user/images/404.jpg') }}"
                            class="img-fluid align-self-center not-found-img" alt="branding logo">
                    </div>
                    <h1 class="font-large-1 my-1 mt-50"> No Record Found!!</h1>
                </div>
            </div>
        </div>
    </div>
    @endif
</section>

<script>
    $('.my-loader').css('display', 'none')
</script>
