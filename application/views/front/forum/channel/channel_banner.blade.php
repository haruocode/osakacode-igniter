<div class="Banner">
    <div class="container">
        <h1 class="Banner__heading Banner__heading--bare">プログラミング掲示板{{$channelName?": $channelName":""}}</h1>
            <span class="utility-text-little utility-muted">
            <strong>{{trans('front.discussions.count-conversation',['count'=>$totalRecord])}}</strong></span>
        @if(check_logged())
            <a id="new-conversation" class="Button Button--Callout Button--Callout-Small"
               href="{{discussion_create_url($channelId)}}">
                {{trans('front.discussions.create-conversation')}}</a>
        @else
            <a id="new-conversation" class="Button Button--Callout Button--Callout-Small"
               href="{{discussion_create_account()}}">
                {{trans('front.discussions.create-account')}}</a>
        @endif
    </div>
</div>