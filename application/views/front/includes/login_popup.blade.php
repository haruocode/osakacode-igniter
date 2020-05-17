<div id="login" class="modal-mask modal-transition" style="display: none;">
    <div class="modal-container modal--small">
        <div class="modal-header">
            <div slot="header">
                <h3>
                    会員ログイン
                </h3>
            </div>
        </div>
        <div class="modal-body">
            <div slot="body">
                <form class="" role="form" id="modal-login">
                    <input type="hidden" name="{{$this->security->get_csrf_token_name()}}"
                    value="{{$this->security->get_csrf_hash()}}">
                    <div class="form-group">
                        <input type="email" id="email" name="email" placeholder="メールアドレス" required="">
                    </div>
                    <div class="form-group">
                        <input type="password" id="password" name="password" placeholder="パスワード" required="">
                    </div>

                    <div class="form-group">
                        <button class="Button Button--Callout">
                            <span>ログイン</span>
                            <div class="la-ball-fall" style="display: none;">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </button>
                    </div>
                    <div class="form-group" style="display: none;" id="login-error">
                        <span class="error utility-center">
                            ログインに失敗しました。
                        </span>
                    </div>

                </form>
            </div>
        </div>

        <div class="modal-footer">
            <div slot="footer">
                <footer>
                    <a href="/password/create" class="utility-muted-link utility-left">
                        パスワードをお忘れですか?
                    </a>

                    <a href="/join" class="utility-muted-link utility-right">
                        会員登録
                    </a>
                </footer>
            </div>
        </div>

    </div>

</div>

<script>
    $("#modal-login").submit(function(){
        var $form = $(this);
        $form.find('button').attr('disabled', true);
        $.ajax({
            type: 'post',
            url: '/login',
            dataType: 'json',
            data: $form.serialize(),
            success: function(resp){
                if(resp.success){
                    window.location.reload();
                    $form.find("#login-error").attr('style', 'display:none');
                } else if (resp.error) {
                    $form.find("#login-error").removeAttr('style');
                    $("#email,#password").keyup(function(){
                        $form.find('button').removeAttr('disabled');
                        $form.find("#login-error").attr('style', 'display:none');
                    });
                }
            }
        });
        return false;
    });
</script>
