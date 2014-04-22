@extends("layout")
@section("content")
    <h2>Delete {{{$username}}} profile</h2>
    <h3>To delete the account, confirm YOUR password</h3>
    <b>Warning - all created vacancies will also be deleted</b>
    
    {{ Form::open([
        //"url"          => URL::route("users/delete"),
        "autocomplete" => "off"
    ]) }}
    
        {{ Form::label("password", "password") }}
        {{ Form::password("password", [
            "placeholder" => "password"
        ]) }}
        @if ($error = $errors->first("password"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
        
        {{ Form::submit("Delete profile") }}
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop