<nav id="main-nav" class="Box Box--Large Box--bright">
    <ul>
        <li class="{{$sidebar_menu=="settings_account"?"active":""}}">
            <a href="{{ BASE_URI.'settings/account'; }}">アカウント</a>
            <i class="material-icons">keyboard_arrow_right</i>
        </li>

        <li class="{{$sidebar_menu=="card_edit"?"active":""}}">
            <a href="{{ BASE_URI.'settings/card/edit'; }}">カード情報</a>
            <i class="material-icons">keyboard_arrow_right</i>
        </li>

        @if($has_card)
            <li class="{{$sidebar_menu=="subscription_plan"?"active":""}}">
                <a href="{{ BASE_URI.'settings/subscription/plan'; }}">現在のプラン</a>
                <i class="material-icons">keyboard_arrow_right</i>
            </li>

            <li class="{{$sidebar_menu=="subscription_invoices"?"active":""}}">
                <a href="{{ BASE_URI.'settings/subscription/invoices'; }}">お支払履歴</a>
                <i class="material-icons">keyboard_arrow_right</i>
            </li>

            <li class="{{$sidebar_menu=="subscription_cancel"?"active":""}}">
                <a href="{{ BASE_URI.'settings/subscription/cancel'; }}">キャンセル</a>
                <i class="material-icons">keyboard_arrow_right</i>
            </li>
        @endif
    </ul>
</nav>