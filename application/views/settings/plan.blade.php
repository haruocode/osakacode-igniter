@extends ('front.template')
@section ('main')

    <div class="container">
    <section class="Setting utility-flex-container">
        @include('settings.includes.sidebar')
    <div class="Setting Box Box--Large Box--bright utility-flex">
        <h2 class="Setting__heading">
            現在のプラン
        </h2>

            <div class="form-group Grid__column six">
                <div class="form-group">
	                @foreach ($data['plans'] as $plans)
				@if ($current_plan != NULL and $plans['id'] == $current_plan->id)
					{{ $plans['description'] }} ({{ $plans['price'] }}円/月)
				@endif
	                @endforeach
			@if (!$current_plan)
				<p>無料プラン</p>

				<form method="POST" action="/settings/subscription/plan" onSubmit="return check()">
				<input type="hidden" name="subscription-plan" value="1">
				<input type="hidden" name="{{$this->security->get_csrf_token_name()}}" value="{{$this->security->get_csrf_hash()}}">
				<button type="submit" class="Button Setting__submit Button Button--Callout">
				<span>
				有料プラン(月額690円)を申し込む
				</span>
				<div class="la-ball-fall" style="display: none;">
				<div></div>
				<div></div>
				<div></div>
				</div>
				</button>
				</form>
			@endif
                </div>
            </div>
    </div>
</section>
</div>
<script>
    $(function () {
        $('select#subscription-plan').change(function(){
            $('.Setting').find('button').removeAttr('disabled');
        })
    })
</script>

<script type="text/javascript"> 
<!-- 

function check(){

	if(window.confirm('有料プランに変更してよろしいですか？')){ // 確認ダイアログを表示

		return true; // 「OK」時は送信を実行

	}
	else{ // 「キャンセル」時の処理

		return false; // 送信を中止

	}

}

// -->
</script>

<!-- Popup box -->
@include('front.includes.popup.confirm_update_plan')
@stop
