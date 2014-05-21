@extends("layout")
@section("content")


<div class="page-header">
    <h1>
        Send private message to <small><a href="{{URL::to("/viewUser/".$receiver_id)}}">{{{$username}}}</a></small>
    </h1>
</div>

    {{ Form::open([
        "autocomplete" => "off",
        "class"        => "form-horizontal",
        "role"         => "form"
    ]) }}
    
    <div class="form-group @if ($errors->first('subject')) has-error@endif">   
        {{ Form::label("subject", "Subject",[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("subject", Input::get("subject"), [
                "placeholder" => "Subject",
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
        {{ Form::label("message", "Message",[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-6">
            {{ Form::textarea("message", Input::get("message"), [
                "placeholder" => "Message",
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
            {{ Form::submit("Send message",["class" => "btn btn-success btn-block"]) }}
        </div>
    </div>
    
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop