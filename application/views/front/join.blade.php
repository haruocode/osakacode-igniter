@extends('front.template')

@section('banner')
<div class="Banner">
	<h1 class="Banner__heading utility-center">
		プログラミングで活きていく。
	</h1>
	<div class="Banner__message utility-center">
		<p>
			プログラミングの楽しさを知って、未来にチャレンジしませんか？
		</p>

		<p>
			月額690円で(たった１回のランチ代で！)あなたに1ヶ月間プログラミングスキルを伝授します。
		</p>
	</div>
</div>
@stop

@section('main')
	@include('front.includes.join.plan')
	@include('front.includes.join.questions')
@stop
