@extends("layout")
@section("content")
    
<span class="page-control btn-group btn-group-sm">
    <a class="btn btn-default" href="{{URL::to("/login/")}}">{{ trans('titles.log-in') }}?</a>
</span>

<div class="page-header">
    <h2>{{ trans('titles.reset-and-change-password') }}</h2>
</div> 

    {{ Form::open([
        "url"          => URL::route("users/reset") . $token,
        "autocomplete" => "off",
        "class"        => "form-horizontal",
        "role"         => "form"
    ]) }}
    
    <div class="form-group">
        @if ($error = $errors->first("token"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>  
    
    <div class="form-group @if ($errors->first('email')) has-error@endif">    
        {{ Form::label("email", trans('forms.email'),[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("email", Input::get("email"), [
                "placeholder" => trans('forms.email'),
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
        {{ Form::label("password", trans('forms.password'),[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::password("password", [
                "placeholder" => trans('forms.password'),
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
        {{ Form::label("password_confirmation", trans('forms.confirm-password'),[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::password("password_confirmation", [
                "placeholder" => trans('forms.confirm-password'),
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
            {{ Form::submit(trans('buttons.reset-password'),["class" => "btn btn-warning btn-block"]) }}
        </div>
    </div>
    
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop