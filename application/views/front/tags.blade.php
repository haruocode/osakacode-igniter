@extends('front.template')
@section('banner')
    <div class="Banner">    <h1 class="Banner__heading utility-center">
            タグ一覧
        </h1>

        <div class="Banner__message utility-center">
            <p>レッスン動画についているタグ別に並べています。</p>
        </div>
    </div>
@stop

@section('main')
    <div class="container">
        <ul id="index" class="section">
            @foreach($list_tags as $tag)
            <li>
                <a href="{{tag_detail_rewrite_url($tag)}}">{{$tag->name}}</a>
                <small class="Label Label--x-small Label--Muted">
                    <a href="{{tag_detail_rewrite_url($tag)}}">{{$tag->count_lesson}}</a>
                </small>
            </li>
            @endforeach
        </ul>
    </div>
@stop
