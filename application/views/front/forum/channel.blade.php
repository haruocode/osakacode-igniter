<?php

/*
 * Created by someone with Netbeans IDE
 * Date: 15-4-2016
 */
?>
@extends('front.template')
@section('banner')
    <div class="Banner">
        <div class="container">
            <h1 class="Banner__heading Banner__heading--bare">
                {{$discuss->title}}
            </h1>
        </div>
    </div>
@stop

@section('banner_footer')
    @include('front.forum.channel.channel_breadcrumb')
@stop
@section('main')
    <div class="container wrap discussions">
        <section class="Grid__row">
            <div>
                <!-- The Question -->
                @if($question)
                @include('front.forum.channel.question',['question'=>$question])
                @endif
                <!-- The Replies -->
                @include('front.forum.channel.reply',['listPost'=>$listPost])
                <!-- The Form to Leave a Reply -->

                @if(check_logged())
                @include('front.forum.channel.reply_form')
                @else
                    <h4 class="utility-center mar-t--lg">
                        この掲示板に投稿するには<a href="/login">ログイン</a>するか
                        <a href="{{discussion_create_account()}}">会員登録</a>を行ってください。
                    </h4>
                @endif

                @include('front.forum.markdown',['markdown'=>'markdown','preview'=>'preview'])

                @include('front.forum.channel.sweet-overlay')
            </div>
        </section>

        @if(check_logged())
        <section class="notification-form">
            {{form_open(discussion_subscribe_url($discuss->id),['id'=>'notifications-form','class'=>'ajax-submit'])}}
            <input id="notification_opt_in" name="notification_opt_in" type="checkbox" value="1" {{$isSubscribe ? "checked" : ""}} onclick="$('#notifications-form').submit()">
            <label for="notification_opt_in">他ユーザから書き込みがあった場合にメールで知らせる</label>
            {{form_close()}}
        </section>
        @endif
    </div>
    <script>
        //        $(function(){
        //            $('.edit-reply-button').click(function(){
        //                var media = $(this).parentsUntil("div[class='Media']");
        //                media.find("div[class='js-reply-body']").css('display', 'none');
        //                media.find("div[class='reply-markdown-body']").css('display','');
        //            })
        //            $('#btn_cancel_edit').click(function(){
        //                var media = $(this).parentsUntil("div[class='Media']");
        //                media.find("div[class='reply-markdown-body']").css('display', 'none');
        //                media.find("div[class='js-reply-body']").css('display','');
        //            })
        //        })
    </script>
@stop
