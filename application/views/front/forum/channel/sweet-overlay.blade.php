<?php
/**
 * Created by PhpStorm.
 * User: hiennq
 * Date: 5/5/16
 * Time: 10:49
 */

?>
<div class="sweet-overlay" tabindex="-1" style="opacity: 0; display: none;"></div>
<div class="sweet-alert hideSweetAlert" data-custom-class="" data-has-cancel-button="true"
     data-has-confirm-button="true" data-allow-outside-click="false" data-has-done-function="true" data-animation="pop"
     data-timer="null" style="display: none; margin-top: -186px; opacity: 0;">
    <div class="sa-icon sa-error" style="display: none;">
      <span class="sa-x-mark">
        <span class="sa-line sa-left"></span>
        <span class="sa-line sa-right"></span>
      </span>
    </div>
    <div class="sa-icon sa-warning" style="display: block;">
        <span class="sa-body"></span>
        <span class="sa-dot"></span>
    </div>
    <div class="sa-icon sa-info" style="display: none;"></div>
    <div class="sa-icon sa-success" style="display: none;">
        <span class="sa-line sa-tip"></span>
        <span class="sa-line sa-long"></span>

        <div class="sa-placeholder"></div>
        <div class="sa-fix"></div>
    </div>
    <div class="sa-icon sa-custom" style="display: none;"></div>
    <h2>Spam?</h2>
    <p style="display: block;">Is this full of spam?</p>
    <fieldset>
        <input type="text" tabindex="3" placeholder="">
        <div class="sa-input-error"></div>
    </fieldset>
    <div class="sa-error-container">
        <div class="icon">!</div>
        <p>Not valid!</p>
    </div>
    <div class="sa-button-container">
        <button class="cancel" tabindex="2" style="display: inline-block; box-shadow: none;" onclick="hideSweetOverLay()">Cancel</button>
        <div class="sa-confirm-button-container">
            <button class="confirm" tabindex="1"
                    style="display: inline-block; box-shadow: none; background-color: rgb(221, 107, 85);">Yes
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
    function showSweetOverLay(method,postId){
        if(method=='delete'){
            $('.sweet-alert h2').text("Are you sure?");
            $('.sweet-alert p').text("This will erase your reply.");
            $('.sweet-alert').attr("_method","delete");
            $('.sweet-alert').attr("_id",postId);
        }else if(method=='spam'){
            $('.sweet-alert').attr("_method","spam");
            $('.sweet-alert').attr("_id",postId);
        }
        $('.sweet-overlay').css({"display":"block","opacity":"1"});
        $('.sweet-alert').css({"display":"block","opacity":"1"});
        $('.sweet-alert').addClass("showSweetAlert visible");
    }
    function hideSweetOverLay(){
        $('.sweet-overlay').css({"display":"none","opacity":"0"});
        $('.sweet-alert').css({"display":"none","opacity":"0"});
        $('.sweet-alert').removeClass("showSweetAlert visible");
    }
    $('.sweet-alert').find("button[class='confirm']").click(function(){
        var method = $('.sweet-alert').attr('_method');
        var postId = $('.sweet-alert').attr('_id');
        if (method=='spam')
        {
            ajaxSpam(postId);
        }else{
            if(method=='delete'){
                ajaxDelete(postId);

            }
        }
        hideSweetOverLay();
    });
</script>
<script>
    function ajaxSpam(postId){
        jQuery.ajax({
            type: "POST",
            dataType: 'json',
            url: "{{spam_url()}}",
            data: {
                '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
                postId
            },
            cache:false,
            success:
                    function(resp) {
                        if(resp.success){
                          $.alert("Okay, thanks for the help!");
                            //show alert done
                        }else if(resp.error){
                            //show error
                        }
                    }
        });
    }
    function ajaxDelete(postId,userId){
        jQuery.ajax({
            type: "POST",
            dataType: 'json',
            url: "{{delete_url()}}",
            data: {
                '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
                postId,
            },
            cache:false,
            success:
                    function(resp) {
                        if(resp.success){
                            deletePost(postId);
                            $.alert("Okay, your reply has been deleted.");
                            //show alert done
                        }else if(resp.error){
                            //show error
                        }
                    }
        });
    }

    function deletePost(postId){
        var select = ".replies #reply-"+postId;
        $(select).slideUp(200).remove();
        if($('#best-answer').find('#reply-'+postId).length) {
          //hidden best answer
          $('#best-answer').hide();
          $('#best-answer').find('#reply-'+postId).remove();
        }
        //$(select).remove();
    }
</script>
