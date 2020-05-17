<?php

/* 
 * Created by someone with Netbeans IDE
 * Date: 22-4-2016
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
                    <!-- The Replies -->
                @include('front.forum.channel.reply')

                @include('front.forum.markdown',['markdown'=>'markdown','preview'=>'preview'])

                @include('front.forum.channel.sweet-overlay')
            </div>
        </section>
    </div>
@stop