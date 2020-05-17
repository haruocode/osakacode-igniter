<div id="main" class="Filterable">
    @include('front.includes.lessons.sidebar')
    <div class="primary">
        <ul class="Lesson-List">
            @foreach($list_lessons as $lesson)
                <li class="Lesson-List__item">
                    @if(check_logged())
                        <span class="Lesson-List__status">
                        <?php $class_form = 'lesson-watched-toggle ajax-submit ' . ($lesson->status ? 'Lesson-Status--completed' : '')?>
                            {{form_open('/lessons/complete',['class'=>$class_form])}}
                            <input type="hidden" name="lesson-id" value="{{ $lesson->id }}">
                            <button type="submit" class="Button--Naked">
                                <i class="Lesson-Status__icon material-icons">check_circle</i>
                            </button>
                            {{form_close()}}
                        </span>
                    @endif
                    <span class="Lesson-List__title utility-flex">
                        @if(isset($lesson->courses))
                        <a href="{{ series_rewrite_url($lesson->courses) }}">
                            <strong>{{ $lesson->courses->title }}</strong>
                        </a>
                        @endif
                        <a href="{{ lessons_rewrite_url($lesson) }}">
                            {{ $lesson->title }}
                        </a>
                    </span>
                    <span class="Lesson-List__date">
                        <?php $lesson_time = date('Y/n/j',strtotime($lesson->updated_at))?>
                        {{ $lesson_time }}
                    </span>
                </li>
            @endforeach
        </ul>
    </div>
</div>
<!-- paging -->
@if($list_lessons)
<ul class="pagination">
<!--    @if($first_page_url)
        <li><a href="{{$first_page_url}}">«</a></li>
    @else
        <li class="disabled"><span>«</span></li>
    @endif

    @if($prev_page_url)
        <li><a href="{{$prev_page_url}}">Previous</a></li>
    @else
        <li class="disabled"><span>Previous</span></li>
    @endif

    <li class="disabled"><span>{{$page}}</span></li>

    @if($next_page_url)
        <li><a href="{{$next_page_url}}">Next</a></li>
    @else
        <li class="disabled"><span>Next</span></li>
    @endif

    @if($last_page_url)
        <li><a href="{{$last_page_url}}">»</a></li>
    @else
        <li class="disabled"><span>»</span></li>
    @endif-->
</ul>
<script>
    var url;
    var maxpage;
    var curpage;
    var i;
    var link;
    var dot="<li class=\"disabled\"><span>...</span></li>";
    curpage="<?php echo $page ?>";
    url="lessons?page=";
    maxpage=<?php echo $total_page ?>;
    if(curpage>1){
        link=url+(parseInt(curpage)-parseInt(1));
        $(".pagination").append("<li><a href='" +link+ "'>«</a></li>");
    }else{
        $(".pagination").append("<li><span>«</span></li>");
    }
    var right;
    var d=maxpage/4;
    if(maxpage>10){
        right=maxpage-(d*2);
    }

    for(i=0;i<maxpage;i++){
        link=url+(i+1);
        if((maxpage>10)&&(i==Math.round(right))&&(curpage<maxpage/2)) {
            $(".pagination").append(dot);
        }
        if((maxpage>10)&&(curpage<maxpage/2)&&(i>=right)&&(d>=0)){
            d--;
            continue;
        }
        if((maxpage>10)&&(curpage>maxpage/2)&&(i>=2)&&(d>=0)){
            d--;
            continue;
        }
        if((i+1)==curpage){
            $(".pagination").append("<li class=\"active disabled\"><span>"+(i+1)+"</span></li>");
        }else{
            $(".pagination").append("<li><a href='" +link+ "'>"+(i+1)+"</a></li>");
        }
        if((maxpage>10)&&(i==1)&&(curpage>maxpage/2)) {
            $(".pagination").append(dot);
        }
    }

    if(curpage<maxpage){
        link=url+(parseInt(curpage)+parseInt(1));
        $(".pagination").append("<li><a href='" +link+ "'>»</a></li>");
    }else{
        $(".pagination").append("<li><span>»</span></li>");
    }

</script>
@endif
