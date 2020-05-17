<article id="reply-form" class="Media">
    <div class="Media__body">

            <?= form_open(discussion_detail_url($discuss->title,$discuss->id,$discuss->channel->name),['novalidate'=>'','onsubmit'=>"myButton.disabled = true; return true;"]); ?>

            <input name="conversation_id" type="hidden" value="{{$discuss->id}}">

            <input name="title" type="hidden" value="{{$discuss->title}}">

            <input name="channel" type="hidden" value="{{$discuss->channel->name}}">

            <input name="lastPage" type="hidden" value="{{$lastPage}}">

            <div class="form-group">
                <textarea name="body" id="markdown" class="padding-m" required=""
                          placeholder="ここにあなたの意見を入力してください。"></textarea>
                <hr>
                <div id="preview">
                    ここにプレビューが表示されます。
                </div>
            </div>

            <p class="utility-subtext utility-muted">
                Use Markdown with <a href="https://help.github.com/articles/github-flavored-markdown" target="_blank">GitHub-flavored</a>
                code blocks.
            </p>


            <button type="submit" name="myButton" class="Button Button--Callout Button--Inline" data-single-click="">
                投稿する
            </button>
            <?= form_close(); ?>
    </div>
</article>
