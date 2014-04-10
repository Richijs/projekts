<nav>
    <div {{ (Request::is('/') ? 'class="active"' : '') }}>
        <a href="{{{ URL::to('') }}}">Home</a>
        <a href="{{{ URL::to('/user/1') }}}">User 1</a>
    </div>
</nav>