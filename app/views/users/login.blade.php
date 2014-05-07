@extends("layout")
@section("content")
    <h2>Log In</h2>

    {{ Form::open([
        "route"        => "users/login",
        "autocomplete" => "off",
        "class"        => "form-horizontal",
        "role"         => "form"
    ]) }}
    
        <div class="form-group @if ($errors->first('username')) has-error@endif">
            
            {{ Form::label("username", "Username",[
                "class"  => "col-sm-4 control-label"
            ]) }}
            <div class="col-sm-4">
                {{ Form::text("username", Input::get("username"), [
                    "placeholder" => "username",
                    "class"       => "form-control"
                ]) }}
            </div>
            
            @if ($error = $errors->first("username"))
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
        
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-4">
                <a href="{{ URL::route("users/request") }}">
                    Forgot password?
                </a>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-4">
                {{ Form::checkbox("remember",true ,[
                    //
                ]) }}
                {{ Form::label("remember","remember me") }}
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-4">
                {{ Form::submit("login",["class" => "btn btn-primary"]) }}
            </div>
        </div>

    {{ Form::close() }}
    
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop