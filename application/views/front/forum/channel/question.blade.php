<div id="question" class="Comment">
    <h1 class="Comment__title">{{$question->discussion->title}}</h1>
    <div class="Media">
        <div class="Media__figure">
            <div class="Thumbnail Thumbnail--medium Thumbnail--Circle">
                <a href="{{link_profile($question->user->username)}}" class="Media__figure">
                    <img src="{{get_avatar_path(isset($question->user_profile->avatar)?$question->user_profile->avatar:"")}}"
                         class="utility-circle" alt="{{$question->user->username}}" width="50">
                </a>
            </div>
        </div>
        <div class="Media__body">
            <h5>
                <a href="{{link_profile($question->user->username)}}">{{$question->user->username}}</a>
                        <span class="utility-muted utility-text-light Comment__days-ago">
                            — {{CommonService::get_instance()->time_elapsed_string('@'.$question->created_at)}}
                        </span>
            </h5>
            <div>
                {{$question->content}}
            </div>

            <!-- The "Best Answer" section -->
            @if($isHasBestAnswer)
            <div class="answer" id="best-answer" style="">
                <div class="Box Box--Small Box--Bare">
                    <h4 class="Box__heading">
                        Best Answer

                                <span class="utility-muted">
                                    — Thread Owner's Choice
                                </span>

                        <i class="material-icons utility-right">school</i>
                    </h4>
                </div>
                {{--clone best comment down here--}}
                <div class="Comment" id="reply-{{$isHasBestAnswer->id}}">
                    <div class="Media">
                        <div class="Media__figure">
                            <div class="Thumbnail Thumbnail--medium Thumbnail--Circle">
                                <a href="{{link_profile($isHasBestAnswer->user->username)}}" class="Media__figure">
                                    <img src="{{get_avatar_path(isset($isHasBestAnswer->user_profile->avatar)?$isHasBestAnswer->user_profile->avatar:"")}}"
                                         class="utility-circle" alt="{{$isHasBestAnswer->user->username}}" width="50" height="50">
                                </a>
                            </div>
                        </div>
                        <div class="Media__body">
                            <h5>
                                <a href="{{link_profile($isHasBestAnswer->user->username)}}">{{$isHasBestAnswer->user->username}}</a>
                                <span class="utility-muted utility-text-light Comment__days-ago">
                                   <a href="{{post_create_url($discuss->channel->name,$discuss->title,$isHasBestAnswer->id)}}">
                                       — {{CommonService::get_instance()->time_elapsed_string('@'.$isHasBestAnswer->created_at)}}
                                   </a>
                                </span>
                            </h5>
                            <!-- The Formatted Body Text -->
                            <div class="js-reply-body">
                                {{$isHasBestAnswer->content}}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            @else
                <div class="answer" id="best-answer" style="display: none">
                    <div class="Box Box--Small Box--Bare">
                        <h4 class="Box__heading">
                            Best Answer

                                <span class="utility-muted">
                                    — Thread Owner's Choice
                                </span>

                            <i class="material-icons utility-right">school</i>
                        </h4>
                    </div>
                </div>
            @endif
        </div>

        <!-- The "Edit Reply" button. -->
        <ul class="Icon-List Comment__edit-links">
            @if($question->isPostOfUser)
            <ul class="Icon-List Comment__edit-links">
                <li class="Icon-List__item edit-reply">
                    <a id="edit-reply-button"
                       href="{{discussion_edit_url($discuss->channel->name,$discuss->title,$discuss->id)}}">
                        <i class="material-icons">mode_edit</i>
                    </a>
                </li>
            </ul>
            @endif
        </ul>

    </div>

    <footer class="Comment__footer">

        <!-- The Like Button -->
        <form class="like-reply-form">
            <ul class="Comment__likes List List--Naked"></ul>
        </form>

        <ul class="Icon-List">
            <li class="Icon-List__item">
                <form class="" action="" onsubmit="return false">
                    <button type="submit" class="Button--Naked"
                            title="Did the author of this thread spam us? Sheesh. People, right?" onclick="showSweetOverLay('spam','{{$question->id}}')"><i
                                class="material-icons">mood_bad</i></button>
                </form>
            </li>
        </ul>

        <ul class="Icon-List Comment__edit-links">

        </ul>

    </footer>

</div>
