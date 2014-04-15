@extends("layout")
@section("content")
    <h2>Register</h2>

    {{ Form::open([
        "url"          => URL::route("users/register"),
        "autocomplete" => "off"
    ]) }}
    {{ Form::label("username", "Username") }}
        {{ Form::text("username", Input::get("username"), [
            "placeholder" => "username"
        ]) }}
        @if ($error = $errors->first("username"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
        {{ Form::label("password", "Password") }}
        {{ Form::password("password", [
            "placeholder" => "password"
        ]) }}
        @if ($error = $errors->first("password"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
        {{ Form::label("password_confirmation", "Confirm") }}
        {{ Form::password("password_confirmation", [
            "placeholder" => "confirm password"
        ]) }}
        @if ($error = $errors->first("password_confirmation"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
        {{ Form::label("email", "Email") }}
        {{ Form::text("email", Input::get("email"), [
            "placeholder" => "email"
        ]) }}
        @if ($error = $errors->first("email"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
        {{ Form::submit("register") }}
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="//polyfill.io"></script>
@stop