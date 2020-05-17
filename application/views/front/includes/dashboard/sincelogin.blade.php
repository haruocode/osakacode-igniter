<div class="Grid__row container section">
    <div class="Grid__column six centered">
        <h2 class="Heading--Fancy">
            <span>あなたが最後にログインしてから・・</span>
        </h2>
        <ul class="Lesson-List ">
            @if(empty($updated_list))
                <li class="Lesson-List__item--empty">
                    特に何もありません。
                </li>
            @else
                @foreach($updated_list as $lesson)
                    <li class="Lesson-List__item">
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
            @endif
        </ul>
    </div>
</div>
