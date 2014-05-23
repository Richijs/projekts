@extends("layout")
@section("content")

    <span class="page-control btn-group btn-group-sm">
        <a class="btn btn-default" href="{{URL::to("/login/")}}">{{ trans('titles.log-in') }}?</a>
    </span>

    <div class="page-header">
        <h2>{{ trans('titles.register') }}</h2>
    </div> 

    {{ Form::open([
        "url"          => URL::route("users/register"),
        "autocomplete" => "off",
        "enctype" => "multipart/form-data",
        "file" => "true",
        "class"        => "form-horizontal",
        "role"         => "form"
    ]) }}
    
    <div class="form-group @if ($errors->first('username')) has-error@endif">
        {{ Form::label("username", trans('forms.username'),[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        <div class="col-sm-4">
            {{ Form::text("username", Input::get("username"), [
                "placeholder" => trans('forms.username'),
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
    
    <div class="form-group @if ($errors->first('firstname')) has-error@endif">    
        {{ Form::label("firstname", trans('forms.firstname'),[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("firstname", Input::get("firstname"), [
                "placeholder" => trans('forms.firstname'),
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
        {{ Form::label("lastname", trans('forms.lastname'),[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("lastname", Input::get("lastname"), [
                "placeholder" => trans('forms.lastname'),
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
        {{ Form::label("userGroup", trans('forms.usergroup'),[
            "class"  => "col-sm-4 control-label required"
        ]) }}
            <div class="col-sm-4">
                <div class="radio">
                {{ Form::label("seeker", trans('forms.job-seeker'),[
                    //"class" => "radio-inline"
                ]) }}
                {{ Form::radio('userType', 3,true,[
                    "id" => "seeker"
                ]) }}
                </div>
                <div class="radio">
                {{ Form::label("employer", trans('forms.employer'),[
                   //"class" => "radio-inline"
                ]) }}
                {{ Form::radio('userType', 2,false,[
                    "id" => "employer"
                ]) }}
                </div>
            </div>
        
        @if ($error = $errors->first("userType"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>
    
    <div class="form-group @if ($errors->first('about')) has-error@endif">    
        {{ Form::label("about", trans('forms.about'),[
            "class"  => "col-sm-4 control-label"
        ]) }}
        
        <div class="col-sm-6">
            {{ Form::textarea("about", Input::get("about"), [
                "placeholder" => trans('forms.about'),
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
    
    <div class="form-group @if ($errors->first('picture')) has-error@endif">  
        {{ Form::label("picture", trans('forms.picture'),[
            "class"  => "col-sm-4 control-label"
        ]) }}
        
        <div class="col-sm-4">
            <div class="form-control">
                {{ Form::file("picture", Input::file("picture"),[
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
            {{ Form::submit(trans('titles.register'),["class" => "btn btn-success btn-block"]) }}
        </div>
    </div>
    
    {{ Form::close() }}
    
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop