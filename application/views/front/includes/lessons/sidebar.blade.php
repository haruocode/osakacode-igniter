<div class="sidebar">
    <h3 class="utility-heading-top">{{trans('front.text.filters')}}</h3>

    <ul class="List--Naked">

        <li class="Filterable__item">
            <h4 class="Filterable__heading">{{trans('front.text.difficulty')}}</h4>

            <label class="Filterable__label">
                <a href="{{ url_filter($filters, 'difficulty', DIFFICULTY_BEGINNER) }}"><input type="radio" name="difficulty"
                        {{$filters['difficulty'] == DIFFICULTY_BEGINNER ? 'checked' : ''}}><span>{{trans('tag.difficulty_level.' . DIFFICULTY_BEGINNER)}}</span></a>
            </label><br>

            <label class="Filterable__label">
                <a href="{{ url_filter($filters, 'difficulty', DIFFICULTY_INTERMEDIATE) }}"><input type="radio" name="difficulty"
                {{$filters['difficulty'] == DIFFICULTY_INTERMEDIATE ? 'checked' : ''}} ><span>{{trans('tag.difficulty_level.' . DIFFICULTY_INTERMEDIATE)}}</span></a>
            </label><br>

            <label class="Filterable__label">
                <a href="{{ url_filter($filters, 'difficulty', DIFFICULTY_ADVANCED) }}"><input type="radio" name="difficulty"
                {{$filters['difficulty'] == DIFFICULTY_ADVANCED ? 'checked' : ''}} ><span>{{trans('tag.difficulty_level.' . DIFFICULTY_ADVANCED)}}</span></a>
            </label>

        </li>


        <li class="Filterable__item">
            <h4 class="Filterable__heading">{{trans('front.text.lesson_type')}}</h4>

            <label class="Filterable__label">
                <a href="{{ url_filter($filters, 'type', 'lesson') }}"> <input type="radio" name="lesson_type"
                        {{$filters['type'] == 'lesson' ? 'checked' : ''}} ><span>{{trans('front.text.single_lesson')}}</span></a>
            </label><br>

            <label class="Filterable__label">
                <a href="{{ url_filter($filters, 'type', 'episode') }}"><input type="radio" name="lesson_type"
                        {{$filters['type'] == 'episode' ? 'checked' : ''}} ><span>{{trans('front.text.series_episode')}}</span></a>
            </label>
        </li>


        <li class="Filterable__item">
            <h4 class="Filterable__heading">{{trans('front.text.length')}}</h4>

            <label class="Filterable__label">
                <a href="{{ url_filter($filters, 'length', 'short') }}"><input type="radio" name="length"
                        {{$filters['length'] == 'short' ? 'checked' : ''}} ><span>{{trans('front.lesson_length.short')}}</span></a>
            </label><br>

            <label class="Filterable__label">
                <a href="{{ url_filter($filters, 'length', 'medium') }}"><input type="radio" name="length"
                        {{$filters['length'] == 'medium' ? 'checked' : ''}}><span>{{trans('front.lesson_length.medium')}}</span></a>
            </label><br>

            <label class="Filterable__label">

                <a href="{{ url_filter($filters, 'length', 'long') }}"><input type="radio" name="length"
                        {{$filters['length'] == 'long' ? 'checked' : ''}} ><span>{{trans('front.lesson_length.long')}}</span></a>
            </label>
        </li>

        <li class="Filterable__item">
            <a href="/lessons" class="Button Button--Block">{{trans('front.text.reset_filter')}}</a>
        </li>
    </ul>
</div>
