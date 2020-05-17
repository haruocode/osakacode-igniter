@extends('front.template')

@section('banner')
    <div class="Banner">
        <h1 class="Banner__heading utility-center">
            大阪コード学園 Index
            <span class="utility-text-little utility-muted">
                {{$tags->name}}
            </span>
        </h1>
    </div>
@stop

@section('main')
    <div class="container">
        <section class="Grid__row">
            <div class="Grid__column six centered">
                <ul class="Lesson-List ">
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
        </section>
    </div>
@stop
