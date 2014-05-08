@extends("layout")
@section("content")
    <h2>Add Job Seeker Data</h2>

    {{ Form::open([
        "url"          => URL::route("seekers/add"),
        "autocomplete" => "off",
        "enctype"      => "multipart/form-data",
        "file"         => "true",
        "class"        => "form-horizontal",
        "role"         => "form"
    ]) }}
    
    <div class="form-group @if ($errors->first('intro')) has-error@endif">    
        {{ Form::label("intro", "Intro text",[
            "class"  => "col-sm-4 control-label"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("intro", Input::get("intro"), [
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
            "class"  => "col-sm-4 control-label"
        ]) }}
        
        <div class="col-sm-6">
            {{ Form::textarea("text", Input::get("text"), [
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
            "class"  => "col-sm-4 control-label"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("phone", Input::get("phone"), [
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
    
    <div class="form-group @if ($errors->first('cv')) has-error@endif"> 
        {{ Form::label("cv", "Your CV",[
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
            {{ Form::submit("Add JobSeek",["class" => "btn btn-success btn-block"]) }}
        </div>
    </div>
    
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop