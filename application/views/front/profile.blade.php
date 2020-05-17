@extends('front.template')

@section('banner')

    <div class="Banner">
        <div class="Media">
            <div class="Media__figure">
                <a href="/@{{$userData->getUsername()}}" class="Media__figure profile-avatar">
                    <img src="{{ get_avatar_path($profile && $profile->avatar ? $profile->avatar : '') }}" class=""
                         alt="{{$userData->getUsername()}}">
                </a>
            </div>
            <div class="Media__body">
                <h1>{{$userData->getUsername()}}</h1>
                <p class="banner-profile__employment utility-muted">
                    <?php
                    if ($profile && $profile->work_place != "") {
                        echo $profile->job_title . " at " . $profile->work_place;
                    }?>
                </p>
                <p class="banner-profile__location">
                    <?php if ($profile && ($profile->hometown != '')){ ?>
                    <?php echo $profile->hometown?>
                    <?php } ?>
                </p>
                @if($isMyProfile)
                    <button id="editProfile" class="Button Button--Inline Button--Small" data-toggle="modal"
                            data-target="#myModal">
                        プロフィール編集
                    </button>
                @endif
            </div>
            <div class="experience">
                <h4 class="experience__count">
                    {{$userData->getExp()}}
                    <span>ポイント</span>
                </h4>
            </div>

        </div>
    </div>
@stop

@section('banner_footer')
    <footer class="Banner__footer">
        <div class="container">
            @if($profile)
                <ul class="utility-left">
                    <?php if ($profile->twitter != "") { ?>
                    <li class="banner-profile__twitter">
                        <!-- <i class="icon-twitter"></i> -->
                        <img src="/images/twitter-icon.png"  width="30">
                        <a href="http://twitter.com/{{$profile->twitter}}">
                            <?php echo "@" . $profile->twitter?>
                        </a>
                    </li>
                    <?php } ?>
                    <?php if ($profile->github != "") { ?>
                    <li class="banner-profile__github">
                        <img src="/images/github-icon.png" width="30">
                        <!-- <i class="icon-github"></i> -->
                        <a href="http://github.com/{{$profile->github}}">
                            <?php echo $profile->github?>
                        </a>
                    </li>
                    <?php } ?>
                    <?php if ($profile->can_hire){?>
                    <li class="banner-profile__hire">
                        <i class="material-icons">accessibility</i>
                        お仕事募集中
                    </li>
                    <?php }?>
                </ul>
                @endif
                <ul class="utility-right">
                    <li class="banner-profile__learning-since">
                        <i class="material-icons icon-profile">card_membership</i>
                         <strong>{{CommonService::get_instance()->getRoundTime($userData->getCreatedAt())}} 前</strong>
                    </li>
                    <li>
                        <i class="material-icons icon-profile">favorite</i>
                        <strong>{{CommonService::get_instance()->count_favorite($userData->getId())}}</strong>
                        お気に入り動画
                    </li>
                    <li>
                        <i class="material-icons icon-profile">done</i>
                        <strong>{{CommonService::get_instance()->count_lesson_complete($userData->getId())}}</strong>
                        レッスン完了
                    </li>
                </ul>
        </div>
    </footer>
@stop

@section('main')
    <style>
        body {
            background: #ffffff;
        }
    </style>
    <div class="container">

        <div class="wrap">

        </div>

        @if($isMyProfile)
            <div class="modal-mask modal-transition" style="display: none;" id="myModal">
                <div class="modal-container modal--medium" id="modal-container">
                    <div class="modal-header">
                        <div slot="header">
                            <h3>プロフィール編集</h3>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div slot="body">
                            {{form_open('/@'.$userData->getUsername())}}
                            <div class="form-group">
                                <label for="website">ウェブサイト:</label>
                                <input class="form-control" placeholder="http://example.com" name="website" type="text"
                                       value="{{$profile?$profile->website:''}}" id="website">
                            </div>
                            <div class="form-group">
                                <label for="Twitter Username:">Twitter:</label>
                                <input name="twitter" type="text" value="{{$profile?$profile->twitter:''}}">
                            </div>
                            <div class="form-group">
                                <label for="Github Username:">Github:</label>
                                <input name="github" type="text" value="{{$profile?$profile->github:''}}">
                            </div>
                            <div class="form-group">
                                <label for="employment">職業:</label>
                                <input name="employment" type="text" value="{{$profile?$profile->work_place:''}}"
                                       id="employment">
                            </div>
                            <div class="form-group">
                                <label for="job_title">職種:</label>
                                <input name="job_title" type="text" value="{{$profile?$profile->job_title:''}}"
                                       id="job_title">
                            </div>
                            <div class="form-group">
                                <label for="available_for_hire">お仕事募集中:</label><br>
                                <input name="available_for_hire" type="checkbox" value="1" id="available_for_hire" {{$profile?($profile->can_hire==0?:"checked"):""}}>
                            </div>
                            <div class="form-group">
                                <label for="location">お住まい:</label>
                                <input name="location" type="text" value="{{$profile?$profile->hometown:''}}"
                                       id="location">
                            </div>
                            <div class="form-group">
                                <button class="Button undefined" id="btn-update">
                            <span>
                                更新
                            </span>
                                    <div class="la-ball-fall" style="display: none;">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </button>
                            </div>
                            <p class="utility-center">
                                <em>

                                </em>
                            </p>
                            {{form_close()}}
                        </div>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        @endif

    </div>
    <script>
        function hidemodal() {
            $("#myModal").hide(250);
        }
        $("#editProfile").click(function () {
            $("#myModal").show(250);
        });

        var mouse_inside = false;
        $('#modal-container').hover(function () {
            mouse_inside = true;
        }, function () {
            mouse_inside = false;
        });
        $("body").mousedown(function () {
            if (!mouse_inside) {
                hidemodal();
            }
        });
        $(window).bind('keydown', function (event) {
            if (event.keyCode === 27) {
                hidemodal();
            }
        });
        // function checkuser {
        //       if($userData===$userName) {
        //         $('.profile-avatar').hide();
        //       }
        // }
    </script>
    @if($isMyProfile)
    @include('front.includes.profile.upload_image')
    @endif
@stop
