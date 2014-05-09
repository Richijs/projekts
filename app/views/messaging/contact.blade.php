@extends("layout")
@section("content")
    <h2>Send email to an administrator:</h2>
    <h3>Leave your information here and Random administrator will be contacted instantly</h3>
    
    {{ Form::open([
        "url"          => URL::route("messaging/contact"),
        "autocomplete" => "off",
        "class"        => "form-horizontal",
        "role"         => "form"
    ]) }}
      
     <div class="form-group @if ($errors->first('username')) has-error@endif">    
        {{ Form::label("username", "Username, Nick or Name",[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("username", $username, [
                "placeholder" => "Username, Nick or Name",
                "class"       => "form-control"
            ]) }}
        </div>
        
        @if ($error = $errors->first("username"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>  
    
    <div class="form-group @if ($errors->first('email')) has-error@endif">     
        {{ Form::label("email", "Your Email",[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("email", $email, [
                "placeholder" => "Your Email",
                "class"       => "form-control"
            ]) }}
        </div>
        
        @if ($error = $errors->first("email"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div> 
    
    <div class="form-group @if ($errors->first('subject')) has-error@endif">    
        {{ Form::label("subject", "E-mail subject",[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("subject", Input::get("subject"), [
                "placeholder" => "subject",
                "class"       => "form-control"
            ]) }}
        </div>
        
        @if ($error = $errors->first("subject"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>
    
    <div class="form-group @if ($errors->first('message')) has-error@endif">   
        {{ Form::label("message", "message",[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-5">
        {{ Form::textarea("message", Input::get("message"), [
            "placeholder" => "Message text",
            "class"       => "form-control",
            "rows"        => "7"
        ]) }}
        </div>
        
        @if ($error = $errors->first("message"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>   
    
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-4">
            {{ Form::submit("Send e-mail",["class" => "btn btn-success btn-block"]) }}
        </div>
    </div>
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop