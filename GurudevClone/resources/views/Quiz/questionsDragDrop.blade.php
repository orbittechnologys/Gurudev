@foreach($questions['data'] as $key=>$list)
    <li class="draggable-item" data-id="{{ $list['id'] }}"> <b class="index_counter"></b> {!! $list['question'] !!}</li>
@endforeach
@if(sizeof($questions)==0)
    <li class="noRecord"><h4>No Questions Found!!</h4></li>
@endif
@if($questions['total']>500)
<div id="pagination" class="row mb-30">
    <div class="col-lg-12">
        <div class="mb-5">
            <ul class="pagination" style=" width: 300px; margin: auto;">
                <li class="page-item page-prev {{ ($questions['current_page']==1) ? 'disabled' : '' }}">
                    <a class="page-link" href="javascript:void(0);" onclick="myPagination('{{ $questions['prev_page_url']}}','full_url')" tabindex="-1">Previous</a>
                </li>

                @for($i=1;$i<=$questions['last_page'];$i++)

                    @if($questions['current_page']<=4)
                        <li class="page-item {{ ($i==$questions['current_page']) ? 'active' : '' }}"><a class="page-link" href="javascript:void(0)" onclick="myPagination({{ $i }})" >{{ $i }}</a></li>
                    @endif


                    @if($i>=5)
                        @if($questions['current_page']>=5)
                            <li class="page-item {{ (1==$questions['current_page']) ? 'active' : '' }}"><a class="page-link"href="javascript:void(0)" onclick="myPagination(1)" >{{ 1 }}</a></li>
                            <li class="page-item"><a class="page-link" style="cursor: default;">...</a></li>
                            <li class="page-item {{ ($questions['current_page']-1==$questions['current_page']) ? 'active' : '' }}"><a class="page-link" href="javascript:void(0)" onclick="myPagination({{ $questions['current_page']-1 }})" >{{ $questions['current_page']-1 }}</a></li>
                            <li class="page-item {{ ($questions['current_page']==$questions['current_page']) ? 'active' : '' }}"><a class="page-link" href="javascript:void(0)" onclick="myPagination({{ $questions['current_page'] }})" >{{ $questions['current_page'] }}</a></li>
                            @if(($questions['current_page']+1)<$questions['last_page'])
                                <li class="page-item {{ ($questions['current_page']+1==$questions['current_page']) ? 'active' : '' }}"><a class="page-link" href="javascript:void(0)" onclick="myPagination({{ $questions['current_page']+1 }})" >{{ $questions['current_page']+1 }}</a></li>
                            @endif
                        @endif

                        @if($questions['current_page']!=$questions['last_page'] && ($questions['current_page']+1)!=$questions['last_page'])
                            <li class="page-item"><a class="page-link" style="cursor: default;">...</a></li>
                            <li class="page-item {{ ($questions['last_page']==$questions['current_page']) ? 'active' : '' }}"><a class="page-link" href="javascript:void(0)" onclick="myPagination({{ $questions['last_page'] }})" >{{ $questions['last_page'] }}</a></li>
                        @endif
                        @break
                    @endif
                @endfor
                <li class="page-item page-next {{ ($questions['current_page']==$questions['last_page']) ? 'disabled' : '' }}">
                    <a class="page-link" href="javascript:void(0)" onclick="myPagination('{{ $questions['next_page_url'] }}', 'full_url')" >Next</a>
                </li>
            </ul>
        </div>
    </div>
</div>
@endif
<script>
    console.log(' total Questions {{$questions['total']}}')
    var questions ='{!! json_encode($questions['data'])  !!}';
    questions=JSON.parse(questions);
    if(questions.length==0)
        $('.listed_questions').addClass('selectCourse');

    for(i=0;i<$('.listed_questions li').length;i++){
       $($('.listed_questions li')[i]).find('.index_counter').text(i+1+'. ')
    }


</script>
<script>

    id = $('.subjects_tab[class*="active"]').attr('data-id')
    $(".droppable-area2 li").attr('data-subject', id)
</script>
