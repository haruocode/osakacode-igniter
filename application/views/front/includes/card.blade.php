<div class="Card">
    <span class="Card__difficulty">
        {{ trans('tag.difficulty_level.' . $card->difficulty) }}
    </span>
    @if($card->status)
    <span class="Card__updated-status Label Label--x-small">
            {{ trans('tag.series_status.' . $card->status) }}
    </span>
    @endif
    <div class="Card__image">
        <a href="{{ series_rewrite_url($card) }}">
            <img src="/images/{{ $card->image }}"
                 class="Card__image" alt="{{ $card->title }}">
            <div class="Card__overlay">
                <i class="material-icons">play_circle_outline</i>
            </div>
        </a>
    </div>
    <div class="Card__details">
        <h3 class="Card__title">
            <a href="{{ series_rewrite_url($card) }}">
                {{ $card->title }}
            </a>
        </h3>
        <div class="Card__count">{{ isset($card->lessons) ? $card->lessons[0]->counted_rows : 0 }}
            <span class="utility-muted">
                動画
            </span>
        </div>
    </div>
</div>
