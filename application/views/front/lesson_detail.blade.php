@extends('front.template')

@section('main')
    <div class="container">
        <section>
            @include('front.includes.lessons.main_video')
        </section>
        @if(isset($series))
            <section>
                <h2 class="Heading--Fancy">
                    <span class="Heading--Fancy__subtitle">
                        レッスン一覧
                    </span>
                    <span>
                        <a href="{{series_rewrite_url($series)}}">
                            {{$series->title}}
                        </a>
                    </span>
                </h2>

                <div class="Grid__row series-outline">
                    <div class="secondary">
                        <img src="{{get_picture_path($series->image)}}"
                             alt="{{$series->title}}" class="utility-space-below">
                    </div>
                    <div class="primary end">
                        <ul class="Lesson-List Lesson-List--numbered">
                            @foreach($series->lessons as $item_lesson)
                            <li class="Lesson-List__item {{$item_lesson->id == $lessons->id ? 'Lesson-List__item--is-current' : ''}}">
                                @if(check_logged())
                                <span class="Lesson-List__status">
                                    <?php $class_form = 'lesson-watched-toggle ajax-submit ' . ($item_lesson->status ? 'Lesson-Status--completed' : '')?>
                                    {{form_open('/lessons/complete',['class'=>$class_form])}}
                                        <input type="hidden" name="lesson-id" value="{{ $item_lesson->id }}">
                                        <button type="submit" class="Button--Naked">
                                            <i class="Lesson-Status__icon material-icons">check_circle</i>
                                        </button>
                                    {{form_close()}}
                                </span>
                                @endif

                                <!-- The Title of the Lesson -->
                                <span class="Lesson-List__title">
                                    <a href="{{series_episode_rewrite_url($series, $item_lesson->order)}}">
                                        {{$item_lesson->title}}
                                        @if($item_lesson->free)
                                            <span class="Label Label--small Label--bright">無料！</span>
                                        @endif
                                    </a>

                                </span>
                                <!-- The Length of the Lesson -->
                                <span class="Lesson-List__length">
                                    <?php $lesson_time = generate_lesson_time($item_lesson->time)?>
                                    {{$lesson_time['m']}}分{{$lesson_time['s']}}秒
                                </span>
                                @if(check_logged())
                                <span class="Lesson-List__watch-later">
                                    {{form_open('/lessons/saves',['class'=>'ajax-submit'])}}
                                        <input type="hidden" name="objectId" value="{{ $item_lesson->id }}">
                                        <button type="submit" class="button-playlist-action
                                            Button Button--with-icon {{$item_lesson->in_watch_later ? 'Button--active' : ''}}" title="あとで見る">
                                            <i class="material-icons">watch_later</i>
                                        </button>
                                    {{form_close()}}
                                </span>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </section>
        @endif
    </div>
    <div class="wrap wrap--light">
        <!--
        <div class="container">
            <h2 class="Heading--Fancy">
                <span class="Heading--Fancy__subtitle">
                    
                </span>
                <span>このレッスンのコメント</span>
            </h2>

            <div class="comments">
                <div id="disqus_thread">
                    近日公開・・
                </div>
            </div>
        </div>
        -->
    </div>
@stop