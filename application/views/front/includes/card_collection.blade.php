<div class="Card-Collection">
    @foreach($list_cards as $card)
        @include('front.includes.card', ['card'=>$card])
    @endforeach
</div>