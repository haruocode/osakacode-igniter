@extends('front.template')


@section('banner')
    @include('front.forum.channel.channel_banner')
@stop
@section('main')
    <div class="container wrap discussions">
        <section id="forum-page" class="Grid__row">
            <div class="sidebar">
                <ul class="List List--Naked">
                    <!--        The channel list -->
                    <li class="active">
                        <a href="{{discussion_url()}}">
                            <span class="channel-square" style="background: grey"></span>
                            <span>Everything</span>
                        </a>
                    </li>
                    @foreach($listChannels as $channel)
                    <li class="{{($channel->id==$channelId)?"active":""}}">
                        <a href="{{discussion_channel_detail_url($channel->name,$channel->id)}}">
                            <span class="channel-square" style="background: grey"></span>
                            <span>{{$channel->name}}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>

            </div>
            <div class="primary">
                <table class="Conversation-List">
                    @foreach($list as $item)
                    <tr class="Conversation-List__item">

                        <!-- The Creator's Avatar -->
                        <td class="Conversation-List__avatar">
                            <div class="Thumbnail Thumbnail--small Thumbnail--Circle">

                                <a href="{{link_profile($item->user->username)}}" class="Media__figure">
                                    <img src="{{ get_avatar_path($item->userProfile ? $item->userProfile->avatar : '') }}"
                                         class="utility-circle"
                                         alt="{{$item->user->username}}"
                                         width="50"
                                         height="50">
                                </a>
                            </div>
                        </td>

                        <!-- The Conversation Title -->
                        <td class="Conversation-List__title">
                            <a href="{{discussion_detail_url($item->title,$item->id,$item->channel->name)}}"
                               class="title ">
                                {{$item->title}}
                            </a>


                            <div class="meta">
                                更新:
                                <a href="{{discussion_detail_url($item->title,$item->id,$item->channel->name,$item->lastPage)}}">
                                    {{CommonService::get_instance()->time_elapsed_string('@'.$item->latestPost->updated)}}
                                </a>

                                by <a href="{{link_profile($item->latestPost->username)}}">{{$item->latestPost->username}}</a>.

                            </div>
                        </td>


                        <!-- The Conversation Channel -->
                        <td class="Conversation-List__channel">
                    <span class="utility-square"
                          style="background: darkred"></span>

                            <a href="{{discussion_channel_detail_url($item->channel->name,$item->channel->id)}}">{{$item->channel->name}}</a>
                        </td>


                        <!-- The Reply Count -->
                        <td class="Conversation-List__reply-count">
                            {{$item->countReply}}
                        </td>

                    </tr>
                    @endforeach
                </table>

                <div>
                    {{$pagination}}
                </div>
            </div>
        </section>
    </div>
@stop
