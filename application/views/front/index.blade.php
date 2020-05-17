@extends('front.template')

@section('banner')
    <div class="Banner">
        <h1>
            結果をコミットする
        </h1>

        <h3>
            文系専用プログラミング学習サイト
        </h3>

        @if(!check_logged())
        <a href="/join" class="Button Button--Callout">
            動画見放題プラン(690円/月)
        </a>

        <a href="/series" class="utility-muted">
            レッスン動画一覧
        </a>
        @else
            <a href="/series" class="Button Button--Callout">
                見る
            </a>
        @endif
    </div>
@stop

@section('main')

    @include('front.includes.home.featured_series')
    @include('front.includes.home.featured_skills')

    @include('front.includes.static_content.level_up')

    @include('front.includes.static_content.testimonials')

    @include('front.includes.static_content.about_author')

    @if($this->session->tempdata('sendMess'))
        @include('front.includes.popup.send_message')
    @endif

    @if($this->session->tempdata('updatePlan'))
        @include('front.includes.popup.update_plan')
    @endif

    @if($this->session->flashdata('registerAlert'))
        <div class="Alert" style="display: block;">
            <i class="material-icons">speaker_notes</i>
            <a href="#" class="Alert__body" target="_blank">{{$this->session->flashdata('registerAlert')}}</a>
        </div>
        <script>
            $(function() {
                setTimeout(function() {
                    $(".Alert").remove();
                }, 3000);
            });
        </script>
    @endif
@stop