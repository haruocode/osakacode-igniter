<div class="Video__signup-overlay">
    <div>
        <h3>すべてはキミのその手から</h3>
        <p>
            「大阪コード学園」ではたくさんのプログラミング学習動画があります。
            月額690円の有料会員にご登録いただくと動画が全て見放題になります。
            <a href="/join">会員登録</a><br/>
            <a href="#" id="log-in">ログイン</a>
            @include('front.includes.login_popup')
        </p>
        <div class="sign-up-buttons">
            <a href="/join" class="Button Button--Callout">
                月額690円で動画見放題プラン
            </a>
        </div>
        <p class="utility-muted">
            <a href="/login">会員ログイン</a>
        </p>

    </div>
</div>

<script>
    $("#log-in").click(function(){
        $("#login").removeAttr("style");
    });
</script>

<script>
    $("#login").click(function(event){
        var target = $(event.target);
        if (target.hasClass("modal-mask") && !target.hasClass("modal-container")) {
            $("#login").hide();
        }
    });
</script>