@extends ('front.template')
@section ('main')
    <div class="container">
        <section class="Setting utility-flex-container">
            @include('settings.includes.sidebar')
            <div class="Setting Box Box--Large Box--bright utility-flex">
                <h2 class="Setting__heading">
                    有料会員のキャンセル
                </h2>

                <div class="Setting__description">
                    <p>現在、有料会員に登録していません。</p>
                </div>
            </div>
        </section>
    </div>
@stop
