<div class="sweet-overlay" tabindex="-1" style="opacity: -0.01; display: none;"></div>

<div class="sweet-alert hideSweetAlert"
    data-custom-class=""
    data-has-cancel-button="true"
    data-has-confirm-button="true"
    data-allow-outside-click="false"
    data-has-done-function="true"
    data-animation="pop"
    data-timer="null"
    style="display: none; margin-top: -198px; opacity: -0.04;">
<div class="sa-icon sa-error" style="display: none;">
      <span class="sa-x-mark">
        <span class="sa-line sa-left"></span>
        <span class="sa-line sa-right"></span>
      </span>
    </div><div class="sa-icon sa-warning" style="display: block;">
      <span class="sa-body"></span>
      <span class="sa-dot"></span>
    </div><div class="sa-icon sa-info" style="display: none;"></div><div class="sa-icon sa-success" style="display: none;">
      <span class="sa-line sa-tip"></span>
      <span class="sa-line sa-long"></span>

      <div class="sa-placeholder"></div>
      <div class="sa-fix"></div>
    </div><div class="sa-icon sa-custom" style="display: none;"></div><h2>本当ですか？</h2>
    <p style="display: block;">購読プランを変更します。</p>
    <fieldset>
      <input type="text" tabindex="3" placeholder="">
      <div class="sa-input-error"></div>
    </fieldset><div class="sa-error-container">
      <div class="icon">!</div>
      <p>正しくありません</p>
    </div><div class="sa-button-container">
      <button class="cancel" tabindex="2" style="display: inline-block; box-shadow: none;">キャンセル</button>
      <div class="sa-confirm-button-container">
        <button class="confirm" tabindex="1" style="display: inline-block; box-shadow: none; background-color: rgb(140, 212, 245);">はい</button><div class="la-ball-fall">
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
    </div>
</div>

<script>
    $('#js-subscription-plan button').click(function(e){
        e.preventDefault();
        $('div.sweet-alert').removeClass('hideSweetAlert');
        $('div.sweet-alert').addClass('showSweetAlert visible');
        $('div.sweet-alert').attr('style','display: block; margin-top: -198px;');
        $('div.sweet-overlay').attr('style', 'display: block');
        $('button.confirm').mouseenter(function() {
            $(this).css("background-color","rgb(134, 204, 235)");
        }).mouseleave(function(){
            $(this).css("background-color","rgb(140, 212, 245)");
        });
    });
</script>

<script>
    $('button.cancel').click(function(e){
        $('div.sweet-alert').addClass('hideSweetAlert');
        $('div.sweet-alert').removeClass('showSweetAlert visible');
        $('div.sweet-alert').attr('style','display: none; margin-top: -198px; opacity: -0.04;');
        $('div.sweet-overlay').attr('style', 'display: none');
    });
</script>

<script>
  $(document).ready(function () {
    $("button.confirm").on("click", function() {
      $(this).attr("disabled", "disabled");
      $form = $('#js-subscription-plan');
      $form.submit();
    });
  });
</script>
