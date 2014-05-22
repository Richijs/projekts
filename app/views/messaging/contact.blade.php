@extends("layout")
@section("content")

    <span class="page-control btn-group btn-group-sm">
        <a class="btn btn-default" href="{{URL::to("/viewAllUsers/")}}">{{ trans('buttons.all-site-users') }}</a>
    </span>

    <div class="page-header">
        <h2>{{ trans('titles.send-email-to-admin') }}
            <div>
                <small>{{ trans('titles.random-admin-will-be-contacted') }}</small>
            </div>
        </h2>
    </div>

    {{ Form::open([
        "url"          => URL::route("messaging/contact"),
        "autocomplete" => "off",
        "class"        => "form-horizontal",
        "role"         => "form"
    ]) }}
      
     <div class="form-group @if ($errors->first('username')) has-error@endif">    
        {{ Form::label("username", trans('forms.username-nick-name'),[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("username", $username, [
                "placeholder" => trans('forms.username-nick-name'),
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
        {{ Form::label("email", trans('forms.your-email'),[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("email", $email, [
                "placeholder" => trans('forms.your-email'),
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
        {{ Form::label("subject", trans('forms.email-subject'),[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("subject", Input::get("subject"), [
                "placeholder" => trans('forms.email-subject'),
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
        {{ Form::label("message", trans('forms.message'),[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-5">
        {{ Form::textarea("message", Input::get("message"), [
            "placeholder" => trans('forms.message'),
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
            {{ Form::submit(trans('forms.send-email'),["class" => "btn btn-success btn-block"]) }}
        </div>
    </div>
    {{ Form::close() }}
    
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop