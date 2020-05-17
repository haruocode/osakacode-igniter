@extends('front.template')

@section('banner')
    <div class="Banner"><h1 class="Banner__heading utility-center">
            個別レッスン一覧
        </h1>
        <div class="Banner__message utility-center">
            <p>
                新着レッスンなどの特定の動画をお探しでしたらこちらからどうぞ
            </p>
        </div>
    </div>
@stop

@section('main')
    <div class="container">
        <section id="pjax-container" class="Grid__row">
            @include('front.includes.lessons.main')
        </section>
    </div>


    <script type="text/javascript" src="{{asset('js/jquery.pjax.js')}}"></script>
    <script>
        $(document).pjax('.Filterable__item a', '#pjax-container', { timeout: 2500 });

        $.pjax.defaults.scrollTo = false;

        $(document).on('pjax:success', function() {
            $('html,body').animate({
                scrollTop: $("#main").offset().top - 20
            }, 350);
        });
    </script>
@stop