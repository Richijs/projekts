@extends("layout")
@section("content")

    <h2>Editing {{{$username}}} user data</h2>
    
    {{ Form::open([
        //"url"          => URL::route("users/edit"),
        "autocomplete" => "off"
    ]) }}
    {{ Form::label("username", "Username") }}
        {{ Form::text("username", $username/*Input::get("username")*/, [
            "placeholder" => "username"
        ]) }}
        @if ($error = $errors->first("username"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
        {{ Form::label("email", "Email") }}
        {{ Form::text("email", $email/*Input::get("email")*/, [
            "placeholder" => "email"
        ]) }}
        @if ($error = $errors->first("email"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
        {{ Form::submit("Save Edit") }}
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop