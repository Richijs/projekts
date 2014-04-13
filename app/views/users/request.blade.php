@extends("layout")
@section("content")
    {{ Form::open([
        "route"        => "users/request",
        "autocomplete" => "off"
    ]) }}
        {{ Form::label("email", "Email") }}
        {{ Form::text("email", Input::get("email"), [
            "placeholder" => "email"
        ]) }}
        {{ Form::submit("reset") }}
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="//polyfill.io"></script>
@stop