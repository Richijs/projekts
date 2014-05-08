@extends("layout")
@section("content")
    <h2>Register</h2>

    {{ Form::open([
        "url"          => URL::route("users/register"),
        "autocomplete" => "off",
        "enctype" => "multipart/form-data",
        "file" => "true",
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
    
    <div class="form-group @if ($errors->first('firstname')) has-error@endif">    
        {{ Form::label("firstname", "Firstname",[
            "class"  => "col-sm-4 control-label"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("firstname", Input::get("firstname"), [
                "placeholder" => "firstname",
                "class"       => "form-control"
            ]) }}
        </div>
        
        @if ($error = $errors->first("firstname"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>
    
    <div class="form-group @if ($errors->first('lastname')) has-error@endif">      
        {{ Form::label("lastname", "Lastname",[
            "class"  => "col-sm-4 control-label"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("lastname", Input::get("lastname"), [
                "placeholder" => "lastname",
                "class"       => "form-control"
            ]) }}
        </div>
        
        @if ($error = $errors->first("lastname"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>
    
    <div class="form-group @if ($errors->first('userType')) has-error@endif">
        {{ Form::label("userGroup", "User Group",[
            "class"  => "col-sm-4 control-label"
        ]) }}
            <div class="col-sm-4">
                <div class="radio">
                {{ Form::label("seeker", "Job seeker",[
                    //"class" => "radio-inline"
                ]) }}
                {{ Form::radio('userType', 3,true,[
                    "id" => "seeker"
                ]) }}
                </div>
                <div class="radio">
                {{ Form::label("employer", "Employer",[
                   //"class" => "radio-inline"
                ]) }}
                {{ Form::radio('userType', 2,false,[
                    "id" => "employer"
                ]) }}
                </div>
            </div>
        
        @if ($error = $errors->first("userType")) <!-- needed? -->
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>
    
    <div class="form-group @if ($errors->first('about')) has-error@endif">    
        {{ Form::label("about", "About",[
            "class"  => "col-sm-4 control-label"
        ]) }}
        
        <div class="col-sm-6">
            {{ Form::textarea("about", Input::get("about"), [
                "placeholder" => "about",
                "class"       => "form-control",
                "rows"        => "7"
            ]) }}
        </div>

        @if ($error = $errors->first("about"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
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
    
    <div class="form-group @if ($errors->first('picture')) has-error@endif">  
        {{ Form::label("picture", "Picture",[
            "class"  => "col-sm-4 control-label"
        ]) }}
        
        <div class="col-sm-4">
            <div class="form-control">
            {{ Form::file("picture", Input::file("picture"),[ //input::get varbūt???  lkm input::old nestrādā uz file :(
                //"placeholder" => "picture"
            ]) }}
            </div>
        </div>
        
        @if ($error = $errors->first("picture"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>    
    
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-4">  
            {{ Form::submit("register",["class" => "btn btn-success btn-block"]) }}
        </div>
    </div>
    
    {{ Form::close() }}
    
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop