@extends('front.template')

@section('banner')
    <div class="Banner">
        <div class="Grid__row--flex">

            <div class="Banner__thumbnail">

                <img src="{{ get_picture_path($series->image) }}"
                     alt="{{ $series->title }}">
            </div>


            <div class="utility-flex">
                <h1 class="Banner__heading">
                    {{ $series->title }}
                </h1>

                <div class="Banner__message">
                    <p>{{ $series->description }}</p>

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
                    <strong>{{count($series->lessons)}}</strong>
                    レッスン
                </li>

                <li>
                    <?php //tính tổng số phút va tong so point của cả series
                    $total_minutes = 0;
                    $total_xp = 0;
                    foreach ($series->lessons as $lesson) {
                        $total_minutes += intval($lesson->time);
                        $total_xp += intval($lesson->point);
                    }
                    ?>
                    <strong>{{ (int)($total_minutes / 60) }}</strong>
                    分
                </li>
                @if(check_logged())
                <li>
                    <strong>
                        {{ $percentage }}
                        <span class="utility-percent">%</span>
                    </strong>
                    完了
                </li>
                <li class="experience">
                    <strong>{{$total_xp}}</strong> ポイント
                    <img src="{{asset('img/experience-badge.png')}}" alt="ポイント">
                </li>
                @endif
            </ul>
        </div>
    </footer>
@stop

@section('main')
    @include('front.includes.series.detail', ['series'=>$series])
    @include('front.includes.series.recommend' ,['data_suggest'=>$data_suggest])
    @include('front.includes.static_content.level_up')
@stop
