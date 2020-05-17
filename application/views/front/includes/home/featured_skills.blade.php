<div class="container section">

    <h2 class="Heading--Fancy">
        <span>おススメのスキル</span>
    </h2>

    <div class="Grid__row">
    <?php $list_skill = CommonService::get_instance()->skill_list()?>
        @foreach($list_skill->result() as $skill)
        <div class="Skill">
            <a href="{{skill_detail_rewrite_url($skill)}}">
                <img src="{{get_picture_path($skill->image)}}" alt="スキル - {{$skill->name}}">
            </a>
        </div>
        @endforeach

    </div>

</div>
