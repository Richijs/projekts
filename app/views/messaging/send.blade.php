@extends("layout")
@section("content")

    <span class="page-control btn-group btn-group-sm">
        <a class="btn btn-default" href="{{URL::to("/viewUser/".$receiver_id)}}">{{{$username}}} {{ trans('buttons.profile') }}</a>
        <a class="btn btn-default" href="{{URL::to("/viewMessages/".Auth::user()->id)}}">{{ trans('buttons.to-messages') }}</a>
        <a class="btn btn-default" href="{{URL::to("/viewAllUsers/")}}">{{ trans('buttons.all-site-users') }}</a>
    </span>

    <div class="page-header">
        <h2>
            {{ trans('titles.send-message-to') }} 
            <small><a href="{{URL::to("/viewUser/".$receiver_id)}}">{{{$username}}}</a></small>
        </h2>
    </div>

    {{ Form::open([
        "autocomplete" => "off",
        "class"        => "form-horizontal",
        "role"         => "form"
    ]) }}
    
    <div class="form-group @if ($errors->first('subject')) has-error@endif">   
        {{ Form::label("subject", trans('forms.subject'),[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("subject", Input::get("subject"), [
                "placeholder" => trans('forms.subject'),
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
        
        <div class="col-sm-6">
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
            {{ Form::submit(trans('forms.send-message'),["class" => "btn btn-success btn-block"]) }}
        </div>
    </div>
    
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop