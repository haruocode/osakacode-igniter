@extends('front.template')

@section('banner')
<div class="Banner">    
	<h1 class="Banner__heading utility-center">
		お問い合わせ
	</h1>
</div>
@stop

@section('main')
<div class="container">
	<form method="POST" id="contactForm" action="/contact" class="Form section">
		<input type="hidden" name="{{$this->security->get_csrf_token_name()}}" 
		value="{{$this->security->get_csrf_hash()}}">

		<div class="form-group">
			<input type="text" name="name" id="name" value="<?= $username ?>" placeholder="お名前" required="">
		</div>


		<div class="form-group">
			<input type="email" name="email" id="email" value="<?= $email ?>" placeholder="メールアドレス" required="">
		</div>


		<div class="form-group">
			<textarea name="question" id="question" placeholder="ご質問、ご要望" required=""></textarea>
		</div>


		<div class="form-group">
			<button type="submit" class="Button Button--Callout" data-single-click="">
				送信
			</button>
		</div>

	</form>

	<h2 class="Heading--Fancy">
		<span>よくある質問</span>
	</h2>

	<section class="questions">

		<div class="Box Box--bright one-half">
			<h4 class="Box__heading">
				プログラミングについて質問したい
			</h4>

			<p>
				プログラミングの質問については100%の回答をお約束できません。できれば「掲示板」や
				レッスン動画の下にあるコメント欄(工事中)へして、他のユーザーからの回答を求めてみてください。
			</p>
		</div>


		<div class="Box Box--bright one-half">
			<h4 class="Box__heading">
				クレジットカード情報を入力しても登録ができません。
			</h4>

			<p>
				申し訳ありません。クレジットカード決済が承認されない場合があります。ただし、当サイトではその原因が分かりかねますので、
				クレジットカードを発行した銀行等の金融機関へお問い合わせ下さいませ。
			</p>
		</div>


		<div class="Box Box--bright one-half">
			<h4 class="Box__heading">
				サイトの機能に不具合があります。
			</h4>

			<p>
				見つけていただきありがとうございます。上記のお問い合わせフォームより不具合の報告をお願いいたします。
				こちらで対応いたします。
			</p>
		</div>
		
		<div class="Box Box--bright one-half">
			<h4 class="Box__heading">
				返金はできますか？
			</h4>

			<p>
				サービスの特性上、返金は受け付けておりません。どうぞご了承くださいませ。
			</p>
		</div>

	</section>
</div>

<script>
	$('#contactForm').one('submit', function() {
		$(this).find('button[type="submit"]').attr('disabled','disabled');
	});
</script>
@stop