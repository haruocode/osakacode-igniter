<div class="replies">
    @foreach($listPost as $post)
        <div class="Comment" id="reply-{{$post->id}}">
            <div class="Media">
                <div class="Media__figure">
                    <div class="Thumbnail Thumbnail--medium Thumbnail--Circle">
                        <a href="{{link_profile($post->user->username)}}" class="Media__figure">
                            <img src="{{get_avatar_path(isset($post->user_profile->avatar)?$post->user_profile->avatar:"")}}"
                                 class="utility-circle" alt="{{$post->user->username}}" width="50" height="50">
                        </a>

                    </div>
                </div>


                <div class="Media__body">

                    <h5>

                        <a href="{{link_profile($post->user->username)}}">{{$post->user->username}}</a>


                <span class="utility-muted utility-text-light Comment__days-ago">
                   <a href="{{post_create_url($discuss->channel->name,$discuss->title,$post->id)}}">
                       — {{CommonService::get_instance()->time_elapsed_string('@'.$post->created_at)}}
                   </a>
                </span>
                    </h5>

                    <!-- The Formatted Body Text -->
                    <div class="js-reply-body">
                        {{$post->content}}
                    </div>

                    <!-- The Editable Body in Markdown -->
                    <div class="reply-markdown-body" style="display: none;">
                        <?= form_open(edit_reply_url($discuss->channel->name, $discuss->title, $post->id), ["class" => "ajax-submit"]); ?>

                        <input name="postId" type="hidden" value="{{$post->id}}">

                        <div class="form-group">
                            <textarea name="body_in_markdown" id="body" placeholder="Ask Away" class="textarea--large"
                                      required="">{{$post->markdown}}</textarea>
                        </div>


                        <div id="edit-reply-form" class="Grid__row">
                            <button class="Button Button--Muted Grid__column six" type="button" id="btn_cancel_edit"
                                    onclick="hideEdit({{$post->id}})">
                                {{trans('front.text.cancel')}}
                            </button>

                            <button class="Button Button--Callout Grid__column six end"
                                    onclick="updatePost({{$post->id}})">
                                    <span>{{trans('front.text.update_your_reply')}}</span>
                                <div class="la-ball-fall" style="display: none;">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </button>
                        </div>

                        <?= form_close(); ?>
                    </div>
                </div>
            </div>

            <footer class="Comment__footer">
                <!-- The Like Button -->
                <?= form_open("/discuss/channels/action/like", ["class" => "like-reply-form ajax-submit-action", "style" => check_logged()?:"visibility: hidden", "onsubmit" => "return false"]); ?>
                <input name="discuss_title" type="hidden" value="{{$discuss->title}}">
                <input name="channel_name" type="hidden" value="{{$discuss->channel->name}}">
                <input name="currentPage" type="hidden" value="{{$currentPage}}">
                <input name="postId" type="hidden" value="{{$post->id}}">
                <button onclick="" type="submit" class="Button--Naked forum-post-like-button">
                    <i class="material-icons {{$post->likeClass}}">thumb_up</i>
                    <span style="display: none;">0</span>
                </button>
                <ul class="Comment__likes List List--Naked">
                    @if($post->listLike)
                        @foreach($post->listLike as $postLike)
                            <li class="Label Label--small">
                                <a href="{{link_profile($postLike->user_name)}}">{{$postLike->user_name}}</a>
                            </li>
                        @endforeach
                    @endif
                </ul>
                <?= form_close() ?>

                <ul class="Icon-List">


                    <!-- The "Report Button" -->
                    <li class="Icon-List__item">
                        <form class="report-spam-form undefined" action="" onsubmit="return false">
                            <button type="submit" class="Button--Naked" title="Is this reply full of spam?"
                                    onclick="showSweetOverLay('spam','{{$post->id}}')"><i
                                        class="material-icons">mood_bad</i></button>
                        </form>
                    </li>

                    <!-- "Did This Answer Your Question?" Button -->
                    @if($post->isDiscussOfUser)
                        <li class="Icon-List__item">
                            <form class="correct-answer-form" action="" onsubmit="return false"
                                  onclick="ajaxBestPost('{{$post->id}}','{{$post->discussion_id}}')">
                                <button type="submit" class="Button--Naked" data-title="Answered your question?"
                                        title="Did this answer your question?">
                                    <i class="material-icons incomplete">check</i>
                                </button>
                            </form>
                        </li>
                    @endif
                </ul>
                <ul class="Icon-List Comment__edit-links">
                @if($post->isPostOfUser)
                    <!-- Edit Reply Button -->
                        <li class="Icon-List__item edit-reply">
                            <button class="edit-reply-button Button--Naked" onclick="showEdit({{$post->id}})">
                                <i class="material-icons">mode_edit</i>
                            </button>
                        </li>

                    <!-- The Delete Reply Button -->
                    <li class="Icon-List__item delete-reply">
                        <form class="" action="" onsubmit="return false">
                            <button type="submit" class="Button--Naked"
                                    onclick="showSweetOverLay('delete','{{$post->id}}')"><i
                                        class="material-icons">delete</i></button>
                        </form>
                    </li>

                    @endif
                </ul>
            </footer>
        </div>
    @endforeach

    {{--Pagination area--}}
    {{isset($pagination)?$pagination:""}}

    <script>
	//@TODO refactor it. Code like shitttt
        function showEdit(postId) {
            var select = ".replies #reply-" + postId;
            $(select).find('.js-reply-body').hide();
            var editorBody = $(select).find('.reply-markdown-body');
            editorBody.show();
        }
        function hideEdit(postId) {
            var select = ".replies #reply-" + postId;
            $(select).find('.js-reply-body').show();
            $(select).find('.reply-markdown-body').hide();
        }
        function likePost(postId, html) {
            var select = ".replies #reply-" + postId;
            $(select).find(".like-reply-form ul").append(html);
            $(select).find(".like-reply-form i").addClass('is-liked');

        }
        function unLike(postId, userName) {
            var select = ".replies #reply-" + postId;
            $(select).find(".like-reply-form a:contains(" + userName + ") ").parent().remove();
            $(select).find(".like-reply-form i").removeClass('is-liked');
        }
        function showBestPost(postId) {
            var select = ".replies #reply-" + postId;
            $('#question').find(".answer").css("display", "");
            $('#question').find(".Comment").remove();
            $('#question').find(".answer div:first").after($(select).clone());
        }

        function updatePost(postId) {
            var select = ".replies #reply-" + postId;
            var editor = $(select).find("textarea[name='body_in_markdown']");
            var content = $(select).find("div[class='js-reply-body']");
            content.html(md.render(editor.val()));
            hideEdit(postId);
        }
    </script>
    <script>
        function ajaxBestPost(postId, discussId) {
            jQuery.ajax({
                type: "POST",
                dataType: 'json',
                url: "/discuss/channels/action/bestpost",
                data: {
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                    'postId':postId,
                    'discussId':discussId
                },
                cache: false,
                success: function (resp) {
                    if (resp.success) {
                        showBestPost(resp.postId);
                        $.alert("Your best answer has now been assigned. Thanks!");
                    } else if (resp.error) {
                        //show error
                    }
                }
            });
        }

    </script>
    <script>
        $('.ajax-submit-action').submit(function () {
            // submit the form
            $(this).ajaxSubmit({
                dataType: 'json',
                success: function (resp) {
                    if (resp.success) {
                        if (resp.isLike) {
                            $.alert(resp.msg);
                            likePost(resp.postId, resp.html);
                        }
                        if (!resp.isLike) {
                            $.alert(resp.msg);
                            unLike(resp.postId, resp.userName);
                        }
                    }
                },
                error: function (error) {

                    console.log(error);
                }
            });
            // return false to prevent normal browser submit and page navigation
            return false;
        });
    </script>
</div>
