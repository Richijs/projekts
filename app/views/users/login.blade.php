@extends("layout")
@section("content")
    {{ Form::open([
        "route"        => "users/login",
        "autocomplete" => "off"
    ]) }}
        {{ Form::label("username", "Username") }}
        {{ Form::text("username", Input::get("username"), [
            "placeholder" => "username"
        ]) }}
        {{ Form::label("password", "Password") }}
        {{ Form::password("password", [
            "placeholder" => "password"
        ]) }}
        @if ($error = $errors->first("password"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
        {{ Form::submit("login") }}
    {{ Form::close() }}
    
    <a href="{{ URL::route("users/request") }}">
        Aizmirsi paroli?
    </a>
@stop
@section("footer")
    @parent
    <script src="//polyfill.io"></script>
@stop