<div class="sweet-overlay" tabindex="-1" style="display: block;"></div>

<div class="sweet-alert showSweetAlert visible"
data-custom-class=""
data-has-cancel-button="true"
data-has-confirm-button="true"
data-allow-outside-click="false"
data-has-done-function="true"
data-animation="pop"
data-timer="null"
style="display: block; margin-top: -198px;">

    <div class="sa-icon sa-success" style="display: block;">
        <span class="sa-line sa-tip"></span>
        <span class="sa-line sa-long"></span>

        <div class="sa-placeholder"></div>
        <div class="sa-fix"></div>
    </div>

    <h2>
        新しいプランに変更されました。
    </h2>

    <p style="display: block;">
        新しいプランに変更されました。<br />
        どうもありがとうございます。
    </p>

    <fieldset>
        <input type="text" tabindex="3" placeholder="">
        <div class="sa-input-error"></div>
    </fieldset>

    <div class="sa-error-container">
        <div class="icon">!</div>
        <p>正しくありません。</p>
    </div>

    <div class="sa-button-container">
        <div class="sa-confirm-button-container">
            <button class="confirm" tabindex="1" style="display: inline-block; box-shadow: none; background-color: rgb(140, 212, 245);">
                OK
            </button>
            <div class="la-ball-fall">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
</div>

<script>
    $('button.confirm').mouseenter(function() {
        $(this).css("background-color","rgb(134, 204, 235)");
    }).mouseleave(function(){
        $(this).css("background-color","rgb(140, 212, 245)");
    });

    $('button.confirm').click(function(e){
        $('div.sweet-alert').addClass('hideSweetAlert');
        $('div.sweet-alert').removeClass('showSweetAlert visible');
        $('div.sweet-alert').attr('style','display: none; margin-top: -198px; opacity: -0.04;');
        $('div.sweet-overlay').attr('style', 'display: none');
    });
</script>
