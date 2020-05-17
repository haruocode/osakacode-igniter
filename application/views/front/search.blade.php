@extends('front.template')

@section('banner_footer')
<footer class="Banner__footer">
	<div class="container">
		<form role="search" action="/search" class="search" method="GET">

			<div class="form-group--flex">
				<label for="q" class="form-group--flex__icon">
					<i class="material-icons">検索</i>
				</label>


				<input type="text" id="q" name="q" class="input--naked" value="{{ $q }}">


				<select name="q-where" id="q-where" class="utility-hidden">
					<option value="lessons">レッスン一覧</option>
					<option value="forum">掲示板</option>
				</select>
			</div>

		</form>
	</div>
</footer>
@stop

@section('main')
<div class="container">
	<section class="Grid__row search">

		<!-- The Lesson Results -->
		<div class="Grid__column six centered">
			<div class="heading">
				<h2 class="utility-center">関連するレッスン動画</h2>
			</div>
			<ul class="Lesson-List ">
				@if(empty($lessons))
				<li class="Lesson-List__item--empty">
					レッスンがありません。
				</li>
				@else

				@foreach($lessons as $lesson)
				<li class="Lesson-List__item">
					<span class="Lesson-List__title utility-flex">
						@if($lesson->courses)
						<a href="{{ series_rewrite_url($lesson->courses) }}">
							<strong>{{ $lesson->courses->title }}</strong>
						</a>
						@endif

						<a href="{{ lessons_rewrite_url($lesson) }}">
							{{ $lesson->title }}
							@if($lesson->free)
							<span class="Label Label--small Label--bright">無料！</span>
							@endif
						</a>
					</span>

					<span class="Lesson-List__date">
						{{ date('Y/n/j',strtotime($lesson->updated_at)) }}
					</span>
				</li>
				@endforeach

				@endif

			</ul>
		</div>
		</section>
	</div>
	@stop
