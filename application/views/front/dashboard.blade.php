@extends('front.template')

@section('banner')
<div class="Banner">    
    <h1 class="Banner__heading utility-center">
        ダッシュボード
    </h1>
    <div class="Banner__message utility-center">
        <p>
            お帰りなさいませ！あなたのスキルアップを心よりお慶び申し上げます。
            <span class="utility-muted">- 大阪コード学園</span>
        </p>
    </div>
</div>
@stop

@section('main')
    @include('front.includes.dashboard.sincelogin')

    @include('front.includes.dashboard.recently')

    @include('front.includes.dashboard.watchlate')
@stop