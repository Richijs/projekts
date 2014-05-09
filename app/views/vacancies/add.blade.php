@extends("layout")
@section("content")
    <h2>Add a vacancie</h2>

    {{ Form::open([
        "url"          => URL::route("vacancies/add"),
        "autocomplete" => "off",
        "enctype"      => "multipart/form-data",
        "file"         => "true",
        "class"        => "form-horizontal",
        "role"         => "form"
    ]) }}
    
    <div class="form-group @if ($errors->first('name')) has-error@endif">   
        {{ Form::label("vacancieName", "Vacancie Name",[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("name", Input::get("name"), [
                "placeholder" => "Vacancie Name",
                "class"       => "form-control"
            ]) }}
        </div>    
            
        @if ($error = $errors->first("name"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>
    
    <div class="form-group @if ($errors->first('text')) has-error@endif">    
        {{ Form::label("vacancieText", "Vacancie Text",[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-6">
            {{ Form::textarea("text", Input::get("text"), [
                "placeholder" => "Vacancie Text",
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
    
    <div class="form-group @if ($errors->first('company')) has-error@endif"> 
        {{ Form::label("company", "Company name",[
            "class"  => "col-sm-4 control-label"
        ]) }}
        
        <div class="col-sm-4">
            {{ Form::text("company", Input::get("company"), [
                "placeholder" => "Company name",
                "class"       => "form-control"
            ]) }}
        </div>
        
        @if ($error = $errors->first("company"))
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
    
    <div class="form-group @if ($errors->first('poster')) has-error@endif"> 
        {{ Form::label("poster", "Vacancie Poster",[
            "class"  => "col-sm-4 control-label"
        ]) }}
        
        <div class="col-sm-4">
            <div class="form-control">
                {{ Form::file("poster", Input::file("poster"), [ //input::get varbūt???  lkm input::old nestrādā uz file :(
                    "placeholder" => "Vacancie Poster"
                ]) }}
            </div>
        </div>
        
        @if ($error = $errors->first("poster"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div> 
    
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-4">  
            {{ Form::submit("Add vacancie",["class" => "btn btn-success btn-block"]) }}
        </div>
    </div>
    
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop