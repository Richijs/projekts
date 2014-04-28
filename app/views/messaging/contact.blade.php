@extends("layout")
@section("content")
    <h2>Send email to an administrator:</h2>
    <h3>Leave your information here and Random administrator will be contacted instantly</h3>
    
    {{ Form::open([
        "url"          => URL::route("messaging/contact"),
        "autocomplete" => "off",
    ]) }}
      
     <div>    
        {{ Form::label("username", "Username, Nick or Name") }}
        {{ Form::text("username", $username, [
            "placeholder" => "Username, Nick or Name"
        ]) }}
        @if ($error = $errors->first("username"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>  
    
     <div>    
        {{ Form::label("email", "Your Email") }}
        {{ Form::text("email", $email, [
            "placeholder" => "Your Email"
        ]) }}
        @if ($error = $errors->first("email"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div> 
    
    <div>    
        {{ Form::label("subject", "E-mail subject") }}
        {{ Form::text("subject", Input::get("subject"), [
            "placeholder" => "subject"
        ]) }}
        @if ($error = $errors->first("subject"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>
    
    <div>    
        {{ Form::label("message", "message") }}
        {{ Form::textarea("message", Input::get("message"), [
            "placeholder" => "Message text"
        ]) }}
        @if ($error = $errors->first("message"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>   
    
    <div>   
        {{ Form::submit("Send e-mail") }}
    </div>
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop