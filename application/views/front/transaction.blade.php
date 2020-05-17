@extends('front.template')

@section('banner')
<div class="Banner">    
	<h1 class="Banner__heading utility-center">
		特定商取引に関する法律に基づく表記
	</h1>
</div>
@stop

@section('main')
<div class="container">
	<table id="transaction">
		<tr>
			<th>販売事業者名</th>
			<td>(氏名)</td>
		</tr>
		
		<tr>
			<th>代表者または運営統括責任者名</th>
			<td>(氏名)</td>
		</tr>
		
		<tr>
			<th>販売事業者所在地</th>
			<td>(住所)</td>
		</tr>
		
		<tr>
			<th>問い合わせ先</th>
			<td>osakacode@gakuen.com</td>
		</tr>
		
		<tr>
			<th>電話番号</th>
			<td>(電話番号)</td>
		</tr>
		
		<tr>
			<th>販売価格</th>
			<td>商品ページに記載しています。</td>
		</tr>
		
		<tr>
			<th>代金の支払い時期および方法</th>
			<td>ご注文時にクレジットカードにて決済を行ってください。</td>
		</tr>
		
		<tr>
			<th>商品の受け渡し時期および方法</th>
			<td>代金のクレジット決済完了後、サービス提供を開始します。開始時にはメールでご連絡を差し上げます。</td>
		</tr>
		
		<tr>
			<th>返品の取り扱い条件、解約条件</th>
			<td>契約期間内であれば、いつでも解約することができます。解約いただくと翌月(もしくは翌年)のサービス提供並びに請求は行いません。解約は設定画面より行うことが可能です。途中解約による返金は承っておりません。</td>
		</tr>
		
		<tr>
			<th>不良品の取り扱い条件</th>
			<td>商品の性質上、返品は承っておりません</td>
		</tr>
		
		<tr>
			<th>商品代金以外に必要な費用</th>
			<td>消費税</td>
		</tr>
	</table>
</div>
@stop