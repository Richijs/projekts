@extends("layout")
@section("content")
    <h2>Register</h2>

    {{ Form::open([
        "url"          => URL::route("users/register"),
        "autocomplete" => "off",
        "enctype" => "multipart/form-data",
        "file" => "true"
    ]) }}
    
    <div>
        {{ Form::label("username", "Username") }}
        {{ Form::text("username", Input::get("username"), [
            "placeholder" => "username"
        ]) }}
        @if ($error = $errors->first("username"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>    
    <div>    
        {{ Form::label("password", "Password") }}
        {{ Form::password("password", [
            "placeholder" => "password"
        ]) }}
        @if ($error = $errors->first("password"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>    
    <div>    
        {{ Form::label("password_confirmation", "Confirm") }}
        {{ Form::password("password_confirmation", [
            "placeholder" => "confirm password"
        ]) }}
        @if ($error = $errors->first("password_confirmation"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>    
    <div>    
        {{ Form::label("firstname", "Firstname") }}
        {{ Form::text("firstname", Input::get("firstname"), [
            "placeholder" => "firstname"
        ]) }}
        @if ($error = $errors->first("firstname"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>    
    <div>    
        {{ Form::label("lastname", "Lastname") }}
        {{ Form::text("lastname", Input::get("lastname"), [
            "placeholder" => "lastname"
        ]) }}
        @if ($error = $errors->first("lastname"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>
    <div>    
        {{ Form::label("userType", "Job seeker") }}
        {{ Form::radio('userType', 3, true) }}
        
        {{ Form::label("userType", "Employer") }}
        {{ Form::radio('userType', 2) }}
        @if ($error = $errors->first("userType")) <!-- needed? -->
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>
    <div>    
        {{ Form::label("about", "About") }}
        {{ Form::textarea("about", Input::get("about"), [
            "placeholder" => "about"
        ]) }}
        @if ($error = $errors->first("about"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>    
    <div>    
        {{ Form::label("email", "Email") }}
        {{ Form::text("email", Input::get("email"), [
            "placeholder" => "email"
        ]) }}
        @if ($error = $errors->first("email"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>    
    <div>   
        {{ Form::label("picture", "Picture") }}
        {{ Form::file("picture", Input::file("picture"),[ //input::get varbūt???  lkm input::old nestrādā uz file :(
           // "placeholder" => "picture"
        ]) }}
        @if ($error = $errors->first("picture"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>    
    <div>   
        {{ Form::submit("register") }}
    </div>
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop