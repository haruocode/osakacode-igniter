<div class="container section">

    <div class="BlockMessage BlockMessage--With-Spacing">
        {{ trans('front.homepage.featured_series.welcome_text') }}
    </div>

    <h2 class="Heading--Fancy">
        <span><a href="/series">{{ trans('front.homepage.featured_series.title') }}</a></span>
    </h2>

    <div class="Card-Collection">
        @foreach($list_series as $series)
            <div class="Card">
            <span class="Card__difficulty">
                {{ trans('tag.difficulty_level.' . $series->difficulty) }}
            </span>
            @if($series->status)
            <span class="Card__updated-status Label Label--x-small">
            {{ trans('tag.series_status.' . $series->status)}}
            </span>
            @endif
                <div class="Card__image">
                    <a href="{{series_rewrite_url($series)}}">
                        <img src="/images/{{$series->image}}" class="Card__image" alt="{{$series->title}}">
                        <div class="Card__overlay">
                            <i class="mdi mdi-play-circle-outline"></i>
                        </div>
                    </a>
                </div>


                <div class="Card__details">

                    <h3 class="Card__title">
                        <a href="{{series_rewrite_url($series)}}">
                            {{ $series->title }}
                        </a>
                    </h3>

                    <div class="Card__count">
                        {{isset($series->lessons) ? $series->lessons[0]->counted_rows : 0}} <span class="utility-muted">動画</span>
                    </div>
                </div>

            </div>
        @endforeach
    </div>
</div>
