@extends("layout")
@section("content")

    <span class="page-control btn-group btn-group-sm">
        <a class="btn btn-default" href="{{ URL::to("/profile/")}}">{{ trans('buttons.my-profile') }}</a>
    </span>

    <div class="page-header">
        <h2>
            {{ trans('titles.change-password') }}
        </h2>
    </div>

    {{ Form::open([
        "url"          => URL::route("users/changePass"),
        "autocomplete" => "off",
        "class"        => "form-horizontal",
        "role"         => "form"
    ]) }}
    
    <div class="form-group @if ($errors->first('password')) has-error@endif">
        {{ Form::label("current_password", trans('forms.current-password'),[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::password("password", [
                "placeholder" => trans('forms.current-password'),
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
        {{ Form::label("new_password", trans('forms.new-password'),[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::password("new_password", [
                "placeholder" => trans('forms.new-password'),
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
        {{ Form::label("new_password_confirmation", trans('forms.confirm-new-password'),[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::password("new_password_confirmation", [
                "placeholder" => trans('forms.confirm-new-password'),
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
            {{ Form::submit(trans('titles.change-password'),["class" => "btn btn-warning btn-block"]) }}
        </div>
    </div>
        
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop