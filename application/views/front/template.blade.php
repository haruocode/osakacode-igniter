<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.1">
    <title>@if(isset($head_title)){{$head_title}} | 大阪コード学園@else 文系専用プログラミング学習サイト「大阪コード学園」 @endif</title>
    @if(isset($head_keyword))
    <meta name="keyword" content="{{$head_keyword}}">
    @endif
    @if(isset($head_desc))
    <meta name="description" content="{{$head_desc}}">
    @endif
    <link href="{{ asset('css/font1.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-icon.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-icon2.css') }}" rel="stylesheet">
    <link href="{{ asset('css/min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('octions/octicons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('icons/css/materialdesignicons.css') }}" media="all" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="/assets/favicons/32x32/32x32_b.png">
    <script type="text/javascript" src="{{ asset('js/jquery-1.11.3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.form.min.js') }}"></script>
    <script type="text/javascript" src="https://js.pay.jp/"></script>
    <style type="text/css">.modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .9);
        transition: opacity .3s ease;
        display: flex;
        align-items: center
    }

    .modal--medium {
        width: 600px
    }

    .modal--small {
        width: 400px
    }

    .modal-container {
        margin: 0 auto;
        max-height: 90%;
        overflow-y: auto;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        color: #3a3a3a
    }

    .modal-container > * {
        padding: 30px
    }

    .modal-header {
        background: #133259;
        color: #fff
    }

    .modal-header h3 {
        margin: 0;
        color: #fff;
        font-size: 21px
    }

    .modal-footer {
        padding-top: 0;
        margin-bottom: 20px;
        font-size: 16px
    }

    .modal-body + .modal-footer {
        margin-top: -30px
    }

    .modal-enter, .modal-leave {
        opacity: 0
    }

    .modal-enter .modal-container, .modal-leave .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1)
    }</style>
    <style type="text/css">.Button .la-ball-fall {
        width: auto;
        height: 16px
    }</style>
    <style type="text/css">@media (max-width: 1049px) {
        #newsletter-form {
            clear: both;
            margin-top: 1em
        }
    }</style>
    <style type="text/css">.like-reply-form button {
        vertical-align: middle;
        color: #c5c5c5;
        font-size: 14px
    }

    .like-reply-form button .is-liked, .like-reply-form button:hover {
        color: #00baf3
    }

    .like-reply-form button:focus {
        outline: 0
    }

    .like-reply-form button i {
        font-size: 18px
    }</style>

</head>
<body class="{{isset($class_body) ? $class_body : ''}}">
    @include('front.includes.search')
    <div id="root" class="page {{ check_logged() ? 'logged-in' : '' }}">
        <header class="Header">
            <div class="container">
                @include('front.includes.navigation')

                @yield('banner')
            </div>
            @yield('banner_footer')
        </header>

        @yield('main')

        @include('front.includes.footer')
        <script type="text/javascript" src="{{ asset('js/all.min.js') }}"></script>
    </div>

    <?php
    if(isset($_COOKIE['notifylogin']) && $_COOKIE['notifylogin'] == 1){ ?>
        <div class="Alert" style="display: block;">
            <i class="material-icons">speaker_notes</i>
            <a href="#" class="Alert__body" target="_blank">{{ trans('front.homepage.login') }}</a>
        </div>
    <script>
        $(function() {
        setTimeout(function() {
            $(".Alert").hide(500);
        }, 2500);
    });
    </script>
    <?php setcookie('notifylogin', '', time()-1);
    } ?>
    <?php
    if(isset($_COOKIE['notifylogout']) && $_COOKIE['notifylogout'] == 1){ ?>
    <div class="Alert" style="display: block;">
            <i class="material-icons">speaker_notes</i>
            <a href="#" class="Alert__body" target="_blank">{{ trans('front.homepage.logout') }}</a>
    </div>
    <script>
        $(function() {
        setTimeout(function() {
            $(".Alert").hide(500);
        }, 2500);
    });
    </script>
    <?php setcookie('notifylogout', '', time()-1);
    } ?>
</body>
</html>
