@extends('front.template')

@section('banner')
    <div class="Banner">
        @if($type == 'favorite')
            <h1 class="Banner__heading utility-center">
                お気に入り一覧
                <span class="utility-text-little utility-muted">
                    お気に入りレッスン動画が {{count($playlist)}} 個ありまぁ～す
                </span>
            </h1>
        @else
            <h1 class="Banner__heading utility-center">
                あとで見る動画一覧
                <span class="utility-text-little utility-muted">
                    あとで見るレッスン動画が {{count($playlist)}} 個ありまぁ～す
                </span>
            </h1>
        @endif
    </div>
@stop

@section('main')
    <div class="container">
        <section class="Grid__row">
            <div class="Grid__column six centered">
                <ul class="Lesson-List ">
                    @if($playlist)
                        @foreach($playlist as $item)
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
                            とくに何もないのですね・・
                        </li>
                    @endif
                </ul>
            </div>
        </section>
    </div>
@stop
