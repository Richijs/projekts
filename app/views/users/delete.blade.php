@extends("layout")
@section("content")
    <h2>Delete {{{$username}}} profile</h2>
    <h3>To delete the account, confirm YOUR password</h3>
    <b>Warning - all created vacancies will also be deleted</b>
    
    {{ Form::open([
        //"url"          => URL::route("users/delete"),
        "autocomplete" => "off",
        "class"        => "form-horizontal",
        "role"         => "form"
    ]) }}
    
    <div class="form-group @if ($errors->first('password')) has-error@endif">
        {{ Form::label("password", "password",[
            "class"  => "col-sm-4 control-label required"
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
            {{ Form::submit("Delete profile",["class" => "btn btn-danger btn-block"]) }}
        </div>
    </div>
        
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop