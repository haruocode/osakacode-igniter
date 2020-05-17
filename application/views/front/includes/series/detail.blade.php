<div class="container">
    <h2 class="Heading--Fancy">
        <span class="Heading--Fancy__subtitle">
            講座一覧
        </span>
        <span>見て、学んで、書いてみよう</span>
    </h2>

    <div class="section Grid__row">
        <!-- Series Episode List -->
        <div class="outline Grid__column nine {{ check_logged() ? '' : 'centered' }}">
            <ul class="Lesson-List Lesson-List--numbered">
                @foreach($series->lessons as $lesson)
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
                        <span class="Lesson-List__title">
                            <a href="{{ series_episode_rewrite_url($series,$lesson->order) }}">
                                {{ $lesson->title }}
                                @if($lesson->free)
                                    <span class="Label Label--small Label--bright">無料</span>
                                @endif
                            </a>
                        </span>
                        <!-- The Length of the Lesson -->
                        <span class="Lesson-List__length">
                            <?php $lesson_time = generate_lesson_time($lesson->time)?>
                            {{$lesson_time['m']}}分{{$lesson_time['s']}}秒
                        </span>
                        @if(check_logged())
                        <span class="Lesson-List__watch-later">
                            {{form_open('/lessons/saves',['class'=>'ajax-submit'])}}
                                <input type="hidden" name="objectId" value="{{ $lesson->id }}">
                                <button type="submit" class="button-playlist-action
                                    Button Button--with-icon {{$lesson->in_watch_later ? 'Button--active' : ''}}" title="Watch Later">
                                    <i class="material-icons">watch_later</i>
                                </button>
                            {{form_close()}}
                        </span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
        <!-- Sidebar -->
        @if(check_logged())
            <div class="Grid__column three end">
                <div class="Box">
                    <ul class="List List--Buttons">
                        <li>
                            {{form_open('/series/saves',['class'=>'ajax-submit'])}}
                                <input type="hidden" name="objectId" value="{{$series->id}}">
                                <button type="submit" class="button-playlist-action Button Button--with-icon {{$series->in_watch_later ? 'Button--active' : ''}}" title="Watch Later">
                                    <i class="material-icons">watch_later</i>
                                    <span>あとで見る</span>
                                </button>
                            {{form_close()}}
                        </li>
                        <li>
                            <!-- This displays the favorited form and heart icon thing. -->
                            {{form_open('/series/favorite',['class'=>'ajax-submit favorite-form'])}}
                                <input type="hidden" name="objectId" value="{{ $series->id }}">
                                <button type="submit" class="button-playlist-action Button Button--with-icon {{$series->in_favorite ? 'Button--active' : ''}}" title="Favorite Series">
                                    <i class="material-icons">favorite</i>
                                    <span>お気に入りに追加</span>
                                </button>
                            {{form_close()}}
                        </li>
                    </ul>
                </div>
            </div>
        @endif
    </div>
    <!-- /section -->
</div>
