<nav class="Navigation">
    <h1 class="logo">
        <a href="/">
          <img src="/images/logo.gif" alt="大阪コード学園" >
        </a>
    </h1>

    <ul class="Navigation__links">
        <li class="Navigation__link hamburger">
            <i class="material-icons">menu</i>
        </li>

        <li id="js-search-icon" class="Navigation__search Navigation__link">
            <a href="#">
              <span class="mega-octicon octicon-search"></span>
            </a>
        </li>


        <li class="Navigation__link">
            <div class="Dropdown">
                <a href="#" class="Dropdown__heading">ライブラリ</a>

                <span class="octicon octicon-chevron-down"></span>

                <ul class="Dropdown__menu">
                    <li class="Dropdown__item
                        {{ (isset($current_menu) and $current_menu=='series') ? 'active' : '' }}
                    ">
                        <a href="/series">
                            <i class="mdi mdi-checkbox-multiple-blank-outline"></i>
                            講座リスト
                        </a>
                    </li>
                    <li class="Dropdown__item
                        {{ (isset($current_menu) and $current_menu=='lessons') ? 'active' : '' }}
                    ">
                        <a href="/lessons">
                            <i class="mdi mdi-format-list-bulleted"></i>
                            カタログ
                        </a>
                    </li>
                    <li class="Dropdown__item
                        {{ (isset($current_menu) and $current_menu=='tag') ? 'active' : '' }}
                    ">
                        <a href="/tag">
                            <i class="mdi mdi-tag"></i>
                            インデックス
                        </a>
                    </li>
                </ul>
            </div>
        </li>


        <li class="Navigation__link">
            <div class="Dropdown">
                <a href="#" class="Dropdown__heading">
                    スキル
                </a>

                <span class="octicon octicon-chevron-down"></span>

                <ul class="Dropdown__menu">
                    @foreach(CommonService::get_instance()->skill_list()->result() as $skill)
                    <li class="Dropdown__item
                        {{ (isset($current_menu) and $current_menu==url_title($skill->name, '-', TRUE)) ? 'active' : '' }}
                    ">
                        <a href="{{ skill_detail_rewrite_url($skill) }}">
                            <i class="mdi mdi-chart-bar"></i>
                            {{ $skill->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </li>

        <li class="Navigation__link">
            <div class="Dropdown">
                <a href="{{discussion_url()}}" class="Dropdown__heading">{{ trans('front.discussions.menu.discussions') }}</a>
                <span class="octicon octicon-chevron-down"></span>
                <ul class="Dropdown__menu">
                    <li class="Dropdown__item">
                        <a href="{{discussion_url()}}">
                            <i class="material-icons">settings</i>
                            {{ trans('front.discussions.menu.forum') }}
                        </a>
                    </li>
                    @if(check_logged())
                    <li class="Dropdown__item">
                        <a href="{{discussion_create_url()}}">
                            <i class="material-icons">settings</i>
                            {{ trans('front.discussions.menu.create') }}
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </li>

        @if(!check_logged())
        <li class="Navigation__link">
            <a href="#" id="sign-in">
                ログイン
            </a>
            @include('front.includes.login_popup')
        </li>
        <li class="Navigation__link">
            <a href="/join" class="Button Button--Callout Button--Callout-Small">
                    動画見放題
            </a>
         </li>
        @else
        <li class="Navigation__link">
            <div class="Dropdown">
                <a href="#" class="Dropdown__heading">アカウント</a>
                <span class="octicon octicon-chevron-down"></span>
                <ul class="Dropdown__menu">
                    <li class="Dropdown__item
                        {{ (isset($current_menu) and $current_menu=='settings') ? 'active' : '' }}
                    ">
                        <a href="/settings/account">
                            <i class="material-icons">settings</i>
                            設定
                        </a>
                    </li>
                    <li class="Dropdown__item
                        {{ (isset($current_menu) and $current_menu=='profile') ? 'active' : '' }}
                    ">
                        <a href="/@{{CommonService::get_instance()->user_name()}}">
                            <i class="material-icons">contact_mail</i>
                            プロフィール
                        </a>
                    </li>
                    <li class="Dropdown__item
                        {{ (isset($current_menu) and $current_menu=='dashboard') ? 'active' : '' }}
                    ">
                        <a href="/dashboard">
                            <i class="material-icons">dashboard</i>
                            ダッシュボード
                        </a>
                    </li>
                    <li class="Dropdown__item
                        {{ (isset($current_menu) and $current_menu=='favorites') ? 'active' : '' }}
                    ">
                        <a href="/favorites">
                            <i class="material-icons">favorite</i>
                            お気に入り一覧
                        </a>
                    </li>
                    <li class="Dropdown__item
                        {{ (isset($current_menu) and $current_menu=='saves') ? 'active' : '' }}
                    ">
                        <a href="/saves">
                            <i class="material-icons">watch_later</i>
                            あとで見る一覧
                        </a>
                    </li>
                    <li class="Dropdown__item divider" role="separator"></li>
                    <li class="Dropdown__item">
                        <a href="/logout">
                            <i class="material-icons">exit_to_app</i>
                            ログアウト
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="Navigation__link" style="visibility: {{!empty(CommonService::get_instance()->getUserNotification())?:"hidden"}}">
            <div class="Dropdown Notify_dropdown">
                <a href="#" class="Dropdown__heading"><i class="material-icons">notifications_active</i></a>
<!--                <i class="material-icons Notifications_material">notifications_active</i>-->
                <ul class="Dropdown__menu" id="dropdown_menu">
                    <div class="Dropdown_item_area">
                        @foreach(CommonService::get_instance()->getUserNotification() as $notify)
                        <li class="Dropdown__item">
                            <a notify-id="{{$notify->getId()}}" href="{{$notify->getLink()}}">{{$notify->getDescription()}}</a>
                        </li>
                        @endforeach
                    </div>
                    <li id="clear-notifications">
                        <?= form_open(clear_notify_url(),["class" => "ajax-submit", "onsubmit" => "return false"]) ?>
                            <button type="submit" class="Button-Notifications">{{ trans('front.text.notify') }}</button>
                        <?= form_close() ?>
                    </li>
                </ul>
            </div>
        </li>
        @endif
    </ul>
</nav>

<script>
    $(function(){
        $(".Notify_dropdown .Dropdown__menu li[class='Dropdown__item']").each(function(){
            if($(this).click(function(){
                var notifyId = $(this).children("a").attr("notify-id");
                        var arrayId = [notifyId];
                        ajaxClearNotify(arrayId);
            }));
        })
        $("#clear-notifications form button").click(function(){
            $(".Notify_dropdown").parent().css("visibility","hidden");
        })
    })
</script>

<script>
    $("#sign-in").click(function(){
        $("#login").removeAttr("style");
    });
</script>

<script>
    $("#login").click(function(event){
        var target = $(event.target);
        if (target.hasClass("modal-mask") && !target.hasClass("modal-container")) {
            $("#login").hide();
        }
    });
</script>

<script>
    $(document).ready(function(){
    // build a variable to target the search box
    var search_box = $('#js-search')
    // bind a click function to the search_box-trigger
    $('#js-search-icon').click(function(event){
        event.preventDefault();
        event.stopPropagation();
        search_box.slideDown(200);
        $('#js-search-icon a').addClass("active");
        $('#js-search input').focus();
    });
    $("#js-search-icon").click(function(event) {
        if (!$(event.target).closest("#js-search, #js-search-icon, .Button, a").length) {
            event.preventDefault();

        }
    });
    $("#root").click(function(e){
        if (search_box.is(":visible"))
            {
                search_box.slideUp(200);
                $('#js-search-icon a').removeClass("active");
            }
    });
})
</script>

<script>
    function ajaxClearNotify(listId){
        jQuery.ajax({
            type: "POST",
            dataType: 'json',
            url: "{{clear_notify_url()}}",
            data: {
                '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
                'listId':listId,
            },
            cache:false,
            success:
                    function(resp) {
                        if(resp.success){

                        }else if(resp.error){
                            //show error
                        }
                    }
        });
    }
</script>