@extends("layout")
@section("content")
    <h2>Change Your Password</h2>

    {{ Form::open([
        "url"          => URL::route("users/changePass"),
        "autocomplete" => "off",
        "class"        => "form-horizontal",
        "role"         => "form"
    ]) }}
    
    <div class="form-group @if ($errors->first('password')) has-error@endif">
        {{ Form::label("current_password", "Current Password",[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::password("password", [
                "placeholder" => "current password",
                "class"       => "form-control"
            ]) }}
        </div>
        
        @if ($error = $errors->first("password"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>    
        
    <div class="form-group @if ($errors->first('new_password')) has-error@endif">
        {{ Form::label("new_password", "New Password",[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::password("new_password", [
                "placeholder" => "new password",
                "class"       => "form-control"
            ]) }}
        </div>
        
        @if ($error = $errors->first("new_password"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>
    
    <div class="form-group @if ($errors->first('new_password_confirmation')) has-error@endif">
        {{ Form::label("new_password_confirmation", "Confirm New Password",[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::password("new_password_confirmation", [
                "placeholder" => "confirm new password",
                "class"       => "form-control"
            ]) }}
        </div>
        
        @if ($error = $errors->first("new_password_confirmation"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>
    
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-4">  
            {{ Form::submit("change password",["class" => "btn btn-warning btn-block"]) }}
        </div>
    </div>
        
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop