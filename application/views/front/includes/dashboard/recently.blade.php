<div class="wrap wrap--light">
    <div class="Grid__row container">
        <div class="Grid__column six large-gutter">
            <h2 class="Heading--Fancy">
                <span>最近コンプリートしたレッスン</span>
            </h2>
            <ul class="Lesson-List ">
                @if($list_lesson_complete)
                    @foreach($list_lesson_complete as $item)
                        <li class="Lesson-List__item">
                            <span class="Lesson-List__title utility-flex">
                                    <a href="{{ $item->course_id ? series_url($item) : lessons_rewrite_url($item) }}">
                                        {{ $item->title }}
                                    </a>
                            </span>
                            <span class="Lesson-List__date">
                                <?php $item_time = date('Y/n/j',strtotime($item->updated_at))?>
                                {{ $item_time }}
                            </span>
                        </li>
                    @endforeach
                @else
                    <li class="Lesson-List__item--empty">
                        特に何もありません。
                    </li>
                @endif
            </ul>
        </div>

        <div class="Grid__column six large-gutter">
            <h2 class="Heading--Fancy">
                <span>
                    <a href="./favorites">
                        最近追加したお気に入り
                    </a>
                </span>
            </h2>
            <ul class="Lesson-List ">
                <li class="Lesson-List__item">
                    @if($favorite_list)
                        @foreach($favorite_list as $item)
                            <li class="Lesson-List__item">
                                <span class="Lesson-List__title utility-flex">
                                    @if($item->object_type == PLAYLIST_OBJECT_TYPE_LESSON)
                                        @if(isset($item->detail->courses))
                                        <a href="{{ series_rewrite_url($item->detail->courses) }}">
                                            <strong>{{ $item->detail->courses->title }}</strong>
                                        </a>
                                        @endif
                                        <a href="{{ lessons_rewrite_url($item->detail) }}">
                                            {{ $item->detail->title }}
                                        </a>
                                    @else
                                        <a href="{{ series_rewrite_url($item->detail) }}">
                                            {{ $item->detail->title }}
                                        </a>
                                    @endif
                                </span>
                                <span class="Lesson-List__date">
                                    <?php $item_time = date('Y/n/j',strtotime($item->detail->updated_at))?>
                                    {{ $item_time }}
                                </span>
                            </li>
                        @endforeach
                    @else
                        <li class="Lesson-List__item--empty">
                            特に何もありません。
                        </li>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</div>
