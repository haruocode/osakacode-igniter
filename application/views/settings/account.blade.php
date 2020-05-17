@extends ('front.template')
@section ('main')

    <div class="container">
        <section class="Setting utility-flex-container">
            @include('settings.includes.sidebar')
            <div class="Setting Box Box--Large Box--bright utility-flex">
                <h2 class="Setting__heading">
                    アカウントの更新
                </h2>

                <form action="/settings/account" method="POST" accept-charset="utf-8" id="form">
                    <input type="hidden" name="csrf_token" value="{{ $token }}">

                    <div class="form-group">
                        <label for="username">ユーザー名:</label>
                        <input required="1" name="username" type="text" value="{{ $user->username }}" id="username">
        		<span class="Error" style="display:none">
						ユーザー名はすでに使用されています。
				</span>
                    </div>

                    <div class="form-group">
                        <label for="email">メールアドレス:</label>
                        <input required='true' name="email" type="email" value="{{ $user->email }}" id="email">
		        <span class="Error" style="display:none">
							メールアドレスはすでに登録されています。
				</span>
                    </div>

                    <div class="form-group">
                        <label for="pass1">パスワード:</label>
                        <input name="pass1" type="password" id="pass1" placeholder="パスワード">
                    </div>

                    <div class="form-group">
                        <label for="pass2">確認用パスワード:</label>
                        <input name="pass2" type="password" id="pass2" placeholder="確認用パスワード">
		        <span class="Error" style="display: none;">
					パスワードが一致していません。ご確認の上もう一度お試しください。
				</span>
				<span class="Error" style="display: none;">
					パスワードは6文字以上で、英字と数字が含まれている必要があります。
				</span>
                    </div>
                    <div class="checkbox form-group">
                        <label for="show_profile">
                            <input id="show_profile"
                                   {{ ($profile && $profile->public_profile) ? 'checked' : '' }} name="show_profile"
                                   type="checkbox">
                            プロフィールを公開する
                        </label>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="Setting__submit Button Button--Callout" data-single-click
                                data-spinner>
                            プロフィールを更新
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <div class="sweet-alert showSweetAlert visible" id="profile_success" data-custom-class=""
         data-has-cancel-button="true" data-has-confirm-button="true" data-allow-outside-click="false"
         data-has-done-function="true" data-animation="pop" data-timer="1700" style="display: none;">
        <div class="sa-icon sa-error" style="display: none;">
      <span class="sa-x-mark">
        <span class="sa-line sa-left"></span>
        <span class="sa-line sa-right"></span>
      </span>
        </div>
        <div class="sa-icon sa-warning pulseWarning" style="display: none;">
            <span class="sa-body pulseWarningIns"></span>
            <span class="sa-dot pulseWarningIns"></span>
        </div>
        <div class="sa-icon sa-info" style="display: none;"></div>
        <div class="sa-icon sa-success" style="display: block;">
            <span class="sa-line sa-tip"></span>
            <span class="sa-line sa-long"></span>

            <div class="sa-placeholder"></div>
            <div class="sa-fix"></div>
        </div>
        <div class="sa-icon sa-custom" style="display:none"></div>
        <h2>完了です！</h2>
        <p style="display: block;">プロフィールが更新されました</p>
        <fieldset>
            <input type="text" tabindex="3" placeholder="">
            <div class="sa-input-error"></div>
        </fieldset>
        <div class="sa-error-container">
            <div class="icon">!</div>
            <p>正しくありません</p>
        </div>
        <div class="sa-button-container">
            <button class="cancel" tabindex="2" style="display: none;">キャンセル</button>
            <div class="sa-confirm-button-container">
                <button class="confirm" tabindex="1"
                        style="display: none; box-shadow: rgba(140, 212, 245, 0.8) 0px 0px 2px, rgba(0, 0, 0, 0.0470588) 0px 0px 0px 1px inset; background-color: rgb(140, 212, 245);">
                    はい
                </button>
                <div class="la-ball-fall">
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $("#pass1,#pass2").keyup(function () {
            var password = $("#pass1").val();
            var c_password = $("#pass2").val();
            if (password !== c_password) {
                $(".Error").eq(2).removeAttr('style');
                $("form").find("button").attr('disabled', true);
            } else if (password == c_password) {
                $(".Error").eq(2).attr('style', "display:none");
                $("form").find("button").removeAttr('disabled');
            }

            var n1 = password.length;
            var n2 = c_password.length;
            if (n1 < 6 || n2 < 6 || !password.match(/\d/) || !c_password.match(/\d/) || !password.match(/[a-z]/i) || !c_password.match(/[a-z]/i)) {
                $("form").find('button').attr('disabled', true);
                $('.Error').eq(3).removeAttr('style');
            } else {
                if (password == c_password)
                    $("form").find('button').removeAttr('disabled');
                $('.Error').eq(3).attr('style', 'display:none');
            }
            if (password == '' && c_password == '') {
                $("form").find('button').removeAttr('disabled');
                $('.Error').eq(3).attr('style', 'display:none');
            }
        });
    </script>

    <script>
        $(function () {
            $('#form').submit(function () {
                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    data: $('#form').serialize(),
                    url: $('#form').attr('action'),
                    success: function (resp) {
                        if (resp.success) {
                            $('#profile_success').show();
                            setTimeout(function () {
                                $('#profile_success').hide();
                                window.location.href = '/settings/account';
                            }, 1000);
                        } else if (resp.error) {
                            if (resp.email_error) {
                                $('.Error').eq(1).removeAttr('style');
                                $('#email').keyup(function () {
                                    $('.Error').eq(1).attr('style', 'display:none');
                                });
                            }
                            if (resp.username_error) {
                                $('.Error').eq(0).removeAttr('style');
                                $('#username').keyup(function () {
                                    $('.Error').eq(0).attr('style', 'display:none');
                                });
                            }
                        }
                    }
                });
                return false;
            });
        });
    </script>

@stop
