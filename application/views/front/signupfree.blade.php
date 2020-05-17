<?php

/* 
 * Created by someone with Netbeans IDE
 * Date: 14-4-2016
 */
?>
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
			<?= form_open(post_signup_url()); ?>
			<section>

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
                            <input id="password_create" name="password_create" type="password" placeholder="パスワード" required="">
                        </div>

                        <!-- Repeat Password -->
                        <div class="form-group">
                            <input id="password_confirmation_create" name="password_confirmation_create" type="password"
                                   placeholder="確認用パスワード" required="">
						<span class="Error" style="display: none;">
							パスワードが一致していません。
						</span>
                            <span class="Error" style="display: none;">
							パスワードは6文字以上で、半角英字と半角数字を含める必要があります。
						</span>
					</div>
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
			</footer>
			<?= form_close(); ?>
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

@stop