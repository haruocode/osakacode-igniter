<?php

/* 
 * Created by someone with Netbeans IDE
 * Date: 23-4-2016
 */

?>
<footer class="Banner__footer Banner__footer--light conversation-breadcrumb">
        <div class="container">
            <ol class="Breadcrumb">
                <li>
                    <a href="{{discussion_url()}}">掲示板</a>
                </li>
                <li>
                    <a href="{{discussion_channel_detail_url($discuss->channel->name,$discuss->channel->id)}}">
                        {{$discuss->channel->name}}
                    </a>
                </li>
                <li>
                    @if($current_menu=='discussions')
                        {{$discuss->title}}
                    @elseif($current_menu=='reply')
                        <a href="{{discussion_detail_url($discuss->title,$discuss->id,$discuss->channel->name)}}">
                            {{$discuss->title}}
                        </a>
                    @endif
                </li>
                @if($current_menu=='reply')
                <li>
                    返信する
                </li>
                @endif
            </ol>
        </div>
</footer>
