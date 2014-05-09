@extends("layout")
@section("content")
    <h2>Editing Job Seek: <a href="/viewSeeker/{{{$id}}}">{{{ $intro }}}</a></h2>

    {{ Form::open([
        //"url"          => URL::route("seekers/edit"),
        "autocomplete" => "off",
        "enctype"      => "multipart/form-data",
        "file"         => "true",
        "class"        => "form-horizontal",
        "role"         => "form"
    ]) }}
    
    <div class="form-group @if ($errors->first('intro')) has-error@endif">   
        {{ Form::label("intro", "Intro text",[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("intro", $intro, [
                "placeholder" => "Intro text",
                "class"       => "form-control"
            ]) }}
        </div>
        
        @if ($error = $errors->first("intro"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>   
    
    <div class="form-group @if ($errors->first('text')) has-error@endif">    
        {{ Form::label("text", "Main Text",[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-6">
            {{ Form::textarea("text", $text, [
                "placeholder" => "Main Text",
                "class"       => "form-control",
                "rows"        => "7"
            ]) }}
        </div>
        
        @if ($error = $errors->first("text"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>  
    
    <div class="form-group @if ($errors->first('phone')) has-error@endif">  
        {{ Form::label("phone", "Phone number",[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("phone", $phone, [
                "placeholder" => "Phone number",
                "class"       => "form-control"
            ]) }}
        </div>
        
        @if ($error = $errors->first("phone"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div> 
    
    <div class="form-group">
        {{ Form::label("currentCV", "Currently uploaded CV",[
            "class"  => "col-sm-4 control-label"
        ]) }}
            <div class="col-sm-4">
                <a class="btn btn-default" href="{{ URL::to("/getCV/".$id) }}">View Current CV</a>
            </div>
    </div>
    
    <div class="form-group @if ($errors->first('cv')) has-error@endif">
        {{ Form::label("cv", "Upload CV",[
            "class"  => "col-sm-4 control-label"
        ]) }}
        
        <div class="col-sm-4">
            <div class="form-control">
                {{ Form::file("cv", Input::file("cv"), [ //input::get varbūt???  lkm input::old nestrādā uz file :(
                    "placeholder" => "CV"
                ]) }}
            </div>
        </div>
        
        @if ($error = $errors->first("cv"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>  
    
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-4">    
            {{ Form::submit("Edit JobSeek",["class" => "btn btn-warning btn-block"]) }}
        </div>
    </div>
    
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop