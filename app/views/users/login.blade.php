@extends("layout")
@section("content")

    <div class="page-header">
        <h2>{{ trans('titles.log-in') }}</h2>
    </div>

    {{ Form::open([
        "route"        => "users/login",
        "autocomplete" => "off",
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
        
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-4">
                <div>
                    <a href="{{ URL::route("users/request") }}">
                        {{ trans('forms.forgot-password-question') }}
                    </a>
                </div>
                
                <div class='checkbox'>
                    {{ Form::checkbox("remember",true,false,[
                        "id" => "remember"
                    ]) }}
                    {{ Form::label("remember",trans('forms.remember-me')) }}
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-4">
                {{ Form::submit(trans('titles.log-in'),["class" => "btn btn-primary btn-block"]) }}
            </div>
        </div>

    {{ Form::close() }}
    
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop