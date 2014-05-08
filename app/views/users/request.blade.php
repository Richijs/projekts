@extends("layout")
@section("content")
    <h2>Request password change</h2>

    {{ Form::open([
        "route"        => "users/request",
        "autocomplete" => "off",
        "class"        => "form-horizontal",
        "role"         => "form"
    ]) }}
    
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
    
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-4">
                {{ Form::submit("request",["class" => "btn btn-warning btn-block"]) }}
            </div>
        </div>
        
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop