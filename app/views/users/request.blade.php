@extends("layout")
@section("content")

<span class="page-control btn-group btn-group-sm">
    <a class="btn btn-default" href="{{URL::to("/login/")}}">{{ trans('titles.log-in') }}?</a>
    <a class="btn btn-default" href="{{URL::to("/register/")}}">{{ trans('titles.register') }}?</a>
</span>

<div class="page-header">
    <h2>{{ trans('titles.request-password-change') }}</h2>
</div> 

    {{ Form::open([
        "route"        => "users/request",
        "autocomplete" => "off",
        "class"        => "form-horizontal",
        "role"         => "form"
    ]) }}
    
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
    
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-4">
                {{ Form::submit(trans('buttons.request'),["class" => "btn btn-warning btn-block"]) }}
            </div>
        </div>
        
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop