
<div class="Video">
    <div class="video">
        <h1 class="Video__title">
            {{$lessons->title}}
        </h1>
        <span class="Video__difficulty Label">
            {{trans('tag.difficulty_level.' . $lessons->difficulty)}}
        </span>

        <div class="Video__box">
            @if(!check_logged() and $lessons->free == 0)
                @include('front.includes.lessons.videos.signup_overlay')
            @elseif(check_logged() and $lessons->free == 0 and $lessons->canSee == false)
                @include('front.includes.lessons.videos.plan_overlay')
            @else
                @include('front.includes.lessons.videos.video')
            @endif

            <div class="Video__details">
                <p class="Video__meta">
                    <strong>
                        <?php
                        $lesson_time = strtotime($lessons->created_at);
                        ?>
                        配信開始日: {{date('Y/n/j',$lesson_time)}}
                        <!-- The associated tool versions for the lesson -->
                    </strong>
                </p>
                <div class="Video__experience">
                    <img src="{{asset('img/experience-badge.png')}}" alt="Experience Points Offered">

                    <strong>{{$lessons->point}} XP</strong>
                </div>
                <div class="Video__body">
                    <p>{{$lessons->description}}</p>
                </div>
                <!-- The tags for the lesson -->
                <ul class="Video__tags utility-list-row utility-clear">
                    @foreach($lessons->tags as $tag)
                    <li>
                        <a href="{{tag_detail_rewrite_url($tag)}}" class="Label">
                            {{$tag->name}}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Watch Later, Favorite, Download buttons -->
        @if(check_logged())
        <div class="Video__buttons Box">
            <ul class="utility-naked-list utility-list-row">
                <li>
                    {{form_open('/lessons/saves', 'class="ajax-submit"')}}
                    <input type="hidden" name="objectId" value="{{$lessons->id}}">
                    <button type="submit" class="Button Button--with-icon button-playlist-action {{$lessons->in_watch_later ? 'Button--active' : ''}}" title="Watch Later">
                        <i class="material-icons">watch_later</i>
                        <span>あとで見る</span>
                    </button>
                    {{form_close()}}
                </li>
                <li>
                    <!-- This displays the favorited form and heart icon thing. -->
                    {{form_open('lessons/favorite','class="favorite-form ajax-submit"')}}
                    <input type="hidden" name="objectId" value="{{$lessons->id}}">
                    <button type="submit" class="Button Button--with-icon button-playlist-action {{$lessons->in_favorite ? 'Button--active' : ''}}" title="Favorite Lesson">
                        <i class="material-icons">favorite</i>
                        <span>お気に入りに追加</span>
                    </button>
                    {{form_close()}}
                </li>
                <li>
                    <a href="/downloads/220" title="Download Video" class="Button Button--with-icon ">
                        <i class="material-icons">cloud_download</i> ダウンロード
                    </a>
                </li>
                <li>
                    <a href="#disqus_thread" class="Button Button--with-icon">
                        <i class="material-icons">comment</i> コメント
                    </a>
                </li>
                <li class="utility-flex-right" id="lesson-complete-toggle">
                    <div class="Lesson-Status">
                        <span class="Lesson-Status__message">
                            {{form_open('/lessons/complete', 'class="ajax-submit ' . ($lessons->completed?'Lesson-Status--completed':'') . '"')}}
                            <input type="hidden" name="lesson-id" value="{{$lessons->id}}">
                            <button type="submit" id="lesson-complete-toggle-button" class="Button--Naked button-playlist-action">
                                <i class="Lesson-Status__icon material-icons">check_circle</i>
                                <span>  {{$lessons->completed?'完了':'未完了'}} </span>
                            </button>
                            {{form_close()}}
                        </span>
                    </div>
                </li>
            </ul>
        </div>
        @endif
    </div>
</div>
