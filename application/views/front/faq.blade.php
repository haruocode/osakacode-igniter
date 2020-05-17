@extends('front.template')

@section('banner')
<div class="Banner">    
	<h1 class="Banner__heading utility-center">
		よくある質問
	</h1>
</div>
@stop

@section('main')
<div class="container">

	<section class="questions">
		<!--
		<div class="Box Box--bright one-half">
			<h4 class="Box__heading">
				質問
			</h4>

			<p>
				回答
			</p>
		</div>
		-->
		
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