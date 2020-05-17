<?php
/**
 * Created by PhpStorm.
 * User: hiennq
 * Date: 4/29/16
 * Time: 11:42
 */
?>
@extends('front.template')

@section('banner')
    <div class="Banner">
        <h1 class="Banner__heading utility-center">
            {{ trans('front.discussions.menu.create') }}
        </h1>
    </div>
@stop

@section('main')
    <div class="container wrap create-conversation discussions">
        <?= form_open(discussion_post_edit_url(),['onsubmit'=>"myButton.disabled = true; return true;"]); ?>
        <input type="hidden" name="discussId" value="{{$data['discussId']}}">
        <input type="hidden" name="postId" value="{{$data['postId']}}">
        <input type="hidden" name="userId" value="{{$data['userId']}}">
        <h1 class="Banner__heading">
            <input type="text" name="title" rows="1" autofocus=""
                   placeholder="{{ trans('front.discussions.create.placeholder_title') }}"
                   value="{{ $data['title']}}" required="">
        </h1>

        <footer id="conversation-breadcrumb" class="Banner__footer Banner__footer--dark">
            <div class="container">
                <ol class="Breadcrumb">
                    <li><a href="{{discussion_url()}}">{{ trans('front.discussions.menu.forum') }}</a></li>

                    <li>
                        <select class="channel-select" name="channel" required>
                          <option value="">Pick a Channel...</option>
                            @foreach($listChannels as $channel)
                              <option value="{{$channel->id}}">{{$channel->name}}</option>
                            @endforeach
                        </select>
                    </li>

                    <li id="title" style="">{{$data['title']}}</li>
                </ol>
            </div>
        </footer>

        <div class="Grid__row">
            <div id="question" class="Comment">
                <div class="Media">
                    <div class="Media__figure">
                        <div class="Thumbnail Thumbnail--medium Thumbnail--Circle">
                            <a href="{{link_profile($userName)}}" class="Media__figure">
                                <img src="{{get_avatar_path(isset($userProfile->avatar)?$userProfile->avatar:"")}}"
                                     class="utility-circle" alt="{{$userName}}" width="50" height="50">
                            </a>
                        </div>
                    </div>

                    <div class="Media__body">
                        <h5>

                            <a href="{{link_profile($userName)}}">{{$userName}}</a>

                            <span class="utility-muted utility-text-light Comment__days-ago">
                                —
                            </span>
                        </h5>
                            <textarea name="body" id="markdown"
                                      placeholder="{{ trans('front.discussions.create.placeholder_post') }}">{{ $data['markdown']}}</textarea>
                        <hr>
                        <div id="preview">
                            {{$data['content']}}
                        </div>
                        <button type="submit" name="myButton" class="Button-Create Button Button--Callout" data-single-click=""
                                title="{{ trans('front.discussions.create.button_title') }}"
                                >
                            {{ trans('front.discussions.create.button_name_update') }}
                        </button>
                    </div>
                </div>

            </div> <!-- end question -->
            <p id="markdown-note">
                * You may use Markdown with <a href="https://help.github.com/articles/github-flavored-markdown"
                                               target="_blank">GitHub-flavored</a> code blocks.
            </p>
        </div>
        <?= form_close(); ?>
    </div>
    <link rel="stylesheet" href="{{asset('libraries/markdown-editor/base16-light.css')}}">
    <link rel="stylesheet" href="{{asset('libraries/markdown-editor/codemirror/lib/codemirror.css')}}">
    <link rel="stylesheet" href="{{asset('libraries/markdown-editor/default.css')}}">
    <link rel="stylesheet" href="{{asset('css/markdown.css')}}">
    @include('front.forum.markdown', ['markdown'=>'markdown', 'preview'=>'preview'])
    <script>
        $(function(){
            $("select[name='channel']").val("<?php echo $data['channel_id']; ?>");
        });
    </script>
    <script>
        $(function () {
            $(".Banner__heading input[name='title']").keyup(function(){
                if($(this).val()!=''){
                    $("#conversation-breadcrumb .container .Breadcrumb li[id='title']").text($(this).val());
                    $("#conversation-breadcrumb .container .Breadcrumb li[id='title']").css("display","");
                }else{
                    $("#conversation-breadcrumb .container .Breadcrumb li[id='title']").css("display","none");
                }
            })
        })
    </script>

    <script>
        $(function(){
            $("#markdown").on("input",function(){
                if($.trim($("#markdown").val())){
                    $(".Media__body button").removeAttr("disabled");
                }else{
                    $(".Media__body button").attr("disabled","true");
                }
            });
        })
    </script>


@stop
