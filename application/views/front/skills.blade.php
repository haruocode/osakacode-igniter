@extends('front.template')

@section('banner')
    <div class="Banner">
        <div class="Grid__row">
            <div class="Grid__column two with-gutter">
                <img src="{{get_picture_path($skill->image)}}">
            </div>

            <div class="Grid__column eight">
                <h1 class="Banner__heading Banner__heading--short">
                    {{$skill->name}}
                </h1>

                <div class="Banner__message">
                    <p>{{$skill->description}}</p>
                </div>
            </div>
        </div>
    </div>
@stop
@section('banner_footer')
    <footer class="Banner__footer">
        <div class="container">
            <ul>
                <li>
                    <strong>{{ $count_series }}</strong> 講座
                </li>
                <li>
                    <strong>{{ $count_lessons }}</strong> レッスン
                </li>
                <li class="utility-right utility-bright" style="top:7px">
                    * 「スキル」は１つのお題を学習するために推奨される動画一覧です。
                </li>
            </ul>
        </div>
    </footer>
@stop

@section('main')
    <div class="skill-wrapper">
        <h2 class="Heading--Fancy">
            少しずつコツコツと・・
        </h2>
        <!--
        <div class="toggles container">
            <a class="active" id="flow">
                <span>flow</span>
                <i class="material-icons">view_carousel</i>
            </a>
            <a id="grid">
                <span>tiles</span>
                <i class="material-icons">view_module</i>
            </a>
        </div>
        -->
        <div class="Skill-List container">
            <div class="as-flow">
                @foreach($list_series as $index=>$series)
                    <div class="Card {{ check_logged() ? ($series->status == 'Completed' ? 'Card--Completed' : '') : '' }}">
                        <span class="Card__index">ステップ {{$index+1}}</span>

                        <div class="Card__image">
                            <a href="{{ series_rewrite_url($series) }}">
                                <img class="Card__image"
                                     src="{{ get_picture_path($series->image) }}"
                                     alt="{{ $series->title }}">

                                <div class="Card__overlay">
                                    <i class="material-icons">play_circle_outline</i>
                                </div>
                            </a>
                        </div>
                        <div class="Card__details">
                            <h3 class="Card__title">
                                <a href="{{ series_rewrite_url($series) }}"> {{ $series->title }} </a>
                            </h3>
                            @if(isset($series->lessons))
                                <div class="Card__count"> {{ $series->lessons[0]->counted_rows }} <span
                                            class="utility-muted">
                                動画
                            </span>
                                </div>
                            @endif
                        </div>
                        <p class="Card__completed-status">
                            <span class="utility-muted">
                                {{ check_logged() ? $series->status : '' }}
                            </span>
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @if($list_lessons)
    <div class="container">
        <div class="wrap">
            <h2 class="Heading--Fancy">
            <span class="Heading--Fancy__subtitle">
                
            </span>
                <span>レッスン学習</span>
            </h2>
            <div class="Grid__row">
                <div class="Grid__column eight centered">
                    <ul class="Lesson-List  Lesson-List--numbered ">
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
                                <a href="{{ lessons_rewrite_url($lesson) }}">
                                    {{ $lesson->title }}
                                    @if($lesson->free)
                                        <span class="Label Label--small Label--bright">Free</span>
                                    @endif
                                </a>
                            </span>
                            <span class="Lesson-List__date">
                                <?php $lesson_time = date('Y/n/j',strtotime($lesson->updated_at))?>
                                {{ $lesson_time }}
                            </span>
                            @if(check_logged())
                            <span class="Lesson-List__watch-later">
                                {{form_open('/lessons/saves',['class'=>'ajax-submit'])}}
                                    <input type="hidden" name="objectId" value="{{ $lesson->id }}">
                                    <button type="submit" class="button-playlist-action
                                        Button Button--with-icon {{$lesson->in_watch_later ? 'Button--active' : ''}}" title="あとで見る">
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
        </div>
    </div>
    @endif
    @include('front.includes.static_content.level_up')
    <script>
        $(function(){
            $(".toggles #flow").click(function(e){
                $(".Skill-List div:first").attr("class","as-flow");
                $(".toggles #flow").attr("class","active");
                $(".toggles #grid").attr("class","");
            })
            $(".toggles #grid").click(function(){
                $(".Skill-List div:first").attr("class","as-grid");
                $(".toggles #grid").attr("class","active");
                $(".toggles #flow").attr("class","");
            })
        })
    </script>
@stop
