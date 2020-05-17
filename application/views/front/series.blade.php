@extends('front.template')
@section('banner_footer')
    <footer class="Banner__footer">
        <div class="container">
            <ol class="Breadcrumb Breadcrumb--Using-Pipes">
                @if(!$is_archived)
                <li class="active">
                    <a href="/series">公開中の動画</a>
                </li>
                <li class="">
                    <a href="/series?archived=1">アーカイブ動画</a>
                </li>
                @else
                <li class="">
                    <a href="/series">公開中の動画</a>
                </li>
                <li class="active">
                    <a href="/series?archived=1">アーカイブ動画</a>
                </li>
                @endif
            </ol>
        </div>
    </footer>
@stop


@section('main')
    <div class="container">
        @include('front.includes.card_collection',['list_cards'=>$list_cards])
    </div>
@stop
