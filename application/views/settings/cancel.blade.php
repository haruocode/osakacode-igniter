@extends ('front.template')
@section ('main')

<div class="container">
    <section class="Setting utility-flex-container">
        @include('settings.includes.sidebar')
    <div class="Setting Box Box--Large Box--bright utility-flex">
        <h2 class="Setting__heading">
            有料プランをキャンセルする
        </h2>

        <div class="Setting__description">
            <p>本当にキャンセルしますか？</p>
        </div>
        <p>
            <a href="/settings/subscription/cancel_confirm">はい、キャンセルします</a>
        </p>
    </div>
</section>
</div>
@stop
