@extends("layout")
@section("content")
    <h2>Reset and change password</h2>

    {{ Form::open([
        "url"          => URL::route("users/reset") . $token,
        "autocomplete" => "off",
        "class"        => "form-horizontal",
        "role"         => "form"
    ]) }}
    
    <div class="form-group">
        @if ($error = $errors->first("token"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }} <!-- jāieliek custom multilang error (ir jābūt norādītam korektam token - apskatiet savu e-pastu vai sūtiet pieprasījumu vēlreiz).. -->
            </div>
        @endif
    </div>  
    
    <div class="form-group @if ($errors->first('email')) has-error@endif">    
        {{ Form::label("email", "Email",[
            "class"  => "col-sm-4 control-label"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("email", Input::get("email"), [
                "placeholder" => "email",
                "class"       => "form-control"
            ]) }}
        </div>
        
        @if ($error = $errors->first("email"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>
    
    <div class="form-group @if ($errors->first('password')) has-error@endif">
        {{ Form::label("password", "Password",[
            "class"  => "col-sm-4 control-label"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::password("password", [
                "placeholder" => "password",
                "class"       => "form-control"
            ]) }}
        </div>
        
        @if ($error = $errors->first("password"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>
    
    <div class="form-group @if ($errors->first('password_confirmation')) has-error@endif">
        {{ Form::label("password_confirmation", "Confirm",[
            "class"  => "col-sm-4 control-label"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::password("password_confirmation", [
                "placeholder" => "confirm password",
                "class"       => "form-control"
            ]) }}
        </div>
        
        @if ($error = $errors->first("password_confirmation"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>
    
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-4"> 
            {{ Form::submit("reset",["class" => "btn btn-warning btn-block"]) }}
        </div>
    </div>
    
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop