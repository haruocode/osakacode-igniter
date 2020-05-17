@extends('front.template')

@section('banner')

    <div class="Banner">
        <h1 class="Banner__heading Banner__heading--light utility-center">
            月額690円でプログラミング動画が見放題！<br>
        </h1>

        <div class="Banner__message utility-center">
            <p>- 大阪コード学園</p><br/><br/>
        </div>
    </div>

@stop

@section('main')

<div class="container">
	<section>
		<div id="signup-form" class="Grid__column eight centered Box Box--bright">
			<form action="/signup/{{$plan}}" method="post" accept-charset="utf-8" id="billing-form">
			<input type="hidden" name="csrf_token" value="{{$token}}">
			<section>
				<fieldset>
					<h2 class="Heading--Fancy">
						<span>会員プラン</span>
					</h2>

					<div class="utility-center Grid__column six centered">
						<div class="form-group">
							<strong>月額プラン(690円/月)</strong>
              <ul>
                <li>すべての有料動画を視聴できます。</li>
                <li>プログラミング掲示板を利用できます。</li>
              </ul>
						</div>

					</div>

				</fieldset>
			</section>

			<section>
				<fieldset>

					<h2 class="Heading--Fancy">
						<span>プロフィール</span>
					</h2>

					<!-- Username -->
					<div class="form-group">
						<input type="text" id="username" name="username" required="" placeholder="ユーザー名" value="">
						<span class="Error" style="display:none;">
							そのユーザー名はすでに使用されています。他のユーザー名を入力してください。
						</span>
                        </div>

                        <!-- Email Address -->
                        <div class="form-group">
                            <input type="text" id="email_create" name="email_create" required="" placeholder="メールアドレス" value="">
						<span class="Error" style="display:none;">
							そのメールアドレスはすでに使用されています。
						</span>
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <input id="password_create" name="password_create" value="password123" type="password" placeholder="パスワード(6文字以上の半角英数字)" required="">
                        </div>

                        <!-- Repeat Password -->
                        <div class="form-group">
                            <input id="password_confirmation_create" name="password_confirmation_create" value="password123" type="password"
                                   placeholder="確認用パスワード" required="">
						<span class="Error" style="display: none;">
							パスワードが一致していません。
						</span>
                            <span class="Error" style="display: none;">
							パスワードは6文字以上でお願いします。
						</span>
					</div>
				</fieldset>
			</section>

			<section>
				<fieldset>
					<h2 class="Heading--Fancy">
						<span>クレジットカード情報</span>
					</h2>

					<!-- Credit Card Number -->
					<div class="form-group">
						<input type="text" value="4242424242424242" id="cc-number" placeholder="クレジットカード番号(16桁)" required="" name="number">
					</div>

					<!-- Expiration Date -->
					<div class="form-group utility-flex-container">
						<label for="cc-expiration-month">
							カードの有効期限:
						</label>

						<select name="exp_month" id="cc-expiration-month">
							<?php list_month(); ?>
						</select>
						<select name="exp_year" id="cc-expiration-year">
							<?php list_year(16); ?>
						</select>
					</div>

					<!-- CVV Number -->
					<div class="form-group">
						<input id="cvv" value="1234" name="cvv_number" type="text" placeholder="セキュリティコード (カードの裏に記載されている３ケタの番号です)" required="">
					</div>
				</fieldset>
			</section>

			<footer>
				<button class="Button Button Button--Callout">
					<span>大阪コード学園に登録する</span>

					<div class="la-ball-fall" style="display: none;">
						<div></div>
						<div></div>
						<div></div>
					</div>
				</button>

				<div class="payment-errors Alert Alert--Inline Alert--Danger" style="display: none;"></div>

			</footer>
			</form>
	</div>
</section>
</div>

@include('front.includes.join.questions')

<div class="container wrap">
	<div class="Testimonial	Testimonial--is-featured">
		<blockquote class="Testimonial__body">
			よく考えよう。プログラミングは大事だよ！
		</blockquote>

		<div class="Testimonial__name">
			<a href="">大阪コード学園</a>
		</div>
	</div>
</div>

<script type="text/javascript">
	Payjp.setPublicKey("pk_test_cad346c1b995b7a93471e9d9");

	var payjpResponseHandler = function(status, response) {

		var $form = $("#billing-form");
		if (response.error) {
			// Show the errors on the form
			$form.find('.payment-errors').text(response.error.message).removeAttr('style');
			$form.find('button').attr('disabled', true);
			$("#cc-number,#cvv").keyup(function(){
                $form.find('button').removeAttr('disabled');
            });
            $("#cc-expiration-month,#cc-expiration-year").change(function(){
                $form.find('button').removeAttr('disabled');
            });
		} else {
			// response contains id and card, which contains additional card details
			var token = response.id;

			// Insert the token into the form so it gets submitted to the server
			$form.append($('<input type="hidden" name="token" />').val(token));
			$.ajax({
				type : 'post',
				url : $form.attr('action'),
                                dataType: 'json',
				data : $form.serialize(),
				success: function(resp) {
                    if (resp.error) {
                        if (resp.username_error) $('.Error').eq(0).removeAttr('style');
                        if (resp.email_error) $('.Error').eq(1).removeAttr('style');
                        $form.find('.payment-errors').text('カード情報のエラーが発生しました。もう一度ご確認ください。' + resp.error).removeAttr('style');
                        if (resp.card_error) $('.')
                        $('#username,#email_create').keyup(function(){
                            $form.find('button').removeAttr('disabled');
                            $('.Error').eq(0).attr('style', 'display:none');
                            $('.Error').eq(1).attr('style', 'display:none');
                        });
                    } else {
                          $('body').append('<div class="Alert" style="display: block;"><i class="material-icons">speaker_notes</i><a href="#" class="Alert__body" target="_blank">登録が完了しました！</a></div>');
                          $(function() {
                                setTimeout(function() {
                                    $(".Alert").hide(500);
                                    setTimeout(function(){
                                    window.location.href = '/home';
                                    },500);
                                }, 1500);
                            });
                    }
				}
			});
		}
	};

	jQuery(function($) {
		$("#billing-form").submit(function(e) {
			var $form = $(this);
            $("span[class*='.Error']").attr('style', 'display:none');
            $form.find('.payment-errors').attr('style', 'display:none');
			// Disable the submit button to prevent repeated clicks
			$form.find('button').attr('disabled', true);
			var data = {
			  number: $form.find('#cc-number').val(),
			  cvc: $form.find('#cvv').val() ,
			  exp_month: $form.find('#cc-expiration-month').val() ,
			  exp_year: $form.find('#cc-expiration-year').val()
			 }
			Payjp.createToken (data, payjpResponseHandler);
			// Prevent the form from submitting with the default action
			return false;
		});
	});
</script>

<script type="text/javascript">
	$("#password_create,#password_confirmation_create").keyup(function(){
		var password = $("#password_create").val();
		var c_password = $("#password_confirmation_create").val();
		if (password !== c_password) {
			$(".Error").eq(2).removeAttr('style');
			$("#billing-form").find("button").attr('disabled', true);
		} else if (password == c_password) {
			$(".Error").eq(2).attr('style', "display:none");
			$("#billing-form").find("button").removeAttr('disabled');
		}

        var n1 = password.length;
        var n2 = c_password.length;
        if (n1 < 6 || n2 < 6 || !password.match(/[a-z0-9]/i) || !c_password.match(/[a-z0-9]/i)){
            	$("#billing-form").find('button').attr('disabled', true);
            $('.Error').eq(3).removeAttr('style');
        } else {
        	if (password == c_password)
            	$("#billing-form").find('button').removeAttr('disabled');
            $('.Error').eq(3).attr('style', 'display:none');
        }
        if (password == '' && c_password == '') {
			$("#billing-form").find('button').removeAttr('disabled');
			$('.Error').eq(3).attr('style', 'display:none');
		}
	});
</script>

@stop
