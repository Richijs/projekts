@extends("layout")
@section("content")
    <h2>Change Your Password</h2>

    {{ Form::open([
        "url"          => URL::route("users/changePass"),
        "autocomplete" => "off"
    ]) }}
        {{ Form::label("current_password", "Current Password") }}
        {{ Form::password("password", [
            "placeholder" => "current password"
        ]) }}
        @if ($error = $errors->first("password"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
        {{ Form::label("new_password", "New Password") }}
        {{ Form::password("new_password", [
            "placeholder" => "new password"
        ]) }}
        @if ($error = $errors->first("new_password"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
        {{ Form::label("new_password_confirmation", "Confirm New Password") }}
        {{ Form::password("new_password_confirmation", [
            "placeholder" => "confirm new password"
        ]) }}
        @if ($error = $errors->first("new_password_confirmation"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
        {{ Form::submit("change password") }}
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop