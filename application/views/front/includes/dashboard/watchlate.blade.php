<div class="wrap wrap--dark">
    <div class="Grid__row container">
        <div class="Grid__column six centered">
            <h2 class="Heading--Fancy">
                <span class="Heading--Fancy__subtitle">
                    次行ってみよう
                </span>

                <span>
                    <a href="/saves">
                        あとで見るレッスン動画
                    </a>
                </span>
            </h2>
            <ul class="Lesson-List ">
                @if($watch_list)
                        @foreach($watch_list as $item)
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
            </ul>
        </div>
    </div>
</div>
