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
        {{ Form::label("password", "Password") }}
        {{ Form::password("password", [
            "placeholder" => "new password"
        ]) }}
        @if ($error = $errors->first("password"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
        {{ Form::label("password_confirmation", "Confirm") }}
        {{ Form::password("password_confirmation", [
            "placeholder" => "confirm new password"
        ]) }}
        @if ($error = $errors->first("password_confirmation"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
        {{ Form::submit("change password") }}
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="//polyfill.io"></script>
@stop