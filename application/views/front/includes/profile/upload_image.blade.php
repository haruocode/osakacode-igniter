<!--    modal for upload avatar-->
<div class="modal-mask modal-transition" style="display: none;" id="modalAvatar">
    <div class="modal-container modal--medium" id="modal-container">
        <div class="modal-header">
            <div slot="header">
                <h3>{{trans('front.text.upload_avatar')}}</h3>
            </div>
        </div>
        <div class="modal-body">
            <div slot="body">
                {{form_open(upload_avatar_url())}}
                <div class="form-group">
                    {{trans('front.text.choose_your_avatar')}}
                    <div class="ajax-upload-container">
                        <div class="row">
                            <div class="col-xs-6">
                                <input type="file" id="avatar-input-file"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 ajax-upload-viewer" style="max-width : 200px;max-height : 200px;overflow:hidden">
                                <input type="hidden" name="avatar-upload" id="avatar-upload" value=""/>
                                <img src="" alt="" style="max-width : 100%" id="avatar-viewer"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button class="Button undefined" id="btn-update-ava">
                        <span>{{trans('front.text.update')}}</span>
                        <div class="la-ball-fall" style="display: none;">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </button>
                </div>
                {{form_close()}}
            </div>
        </div>
        <div class="modal-footer">
        </div>
    </div>
</div>
<script src="{{asset('libraries/plupload/js/plupload.full.min.js')}}"></script>
<script>
    function hidemodalava() {
        $("#modalAvatar").slideUp(250);
    }
    $("#modalAvatar").mousedown(function (event) {
        var target = $(event.target);
        if (target.hasClass("modal-mask") && !target.hasClass("modal-container")) {
            hidemodalava();
        }
    });
    $('.Banner .Media .Media__figure a img').click(function (e) {
        e.preventDefault();
        $('#modalAvatar').slideDown(250);
    });
    $("#btn-update-ava").click(function () {
        hidemodalava();
    })
    $(window).bind('keydown', function (event) {
        if (event.keyCode === 27) {
            hidemodalava();
        }
    });
    $(document).ready(function(){
        UploaderScript.init({
            csrf_token: {csrf_token: Cookies.get('csrf_cookie')},
            browse_button: "avatar-input-file",
            image_wrapper: "avatar-viewer",
            loading: "avatar-viewer"
        }, function () {
            $("#avatar-upload").val(UploaderScript.config.file_name);
        });
    });
</script>
