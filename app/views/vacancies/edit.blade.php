@extends("layout")
@section("content")

    <div class="page-header">
        <h1>
            Editing vacancie: <small><a href="/viewVacancie/{{{$id}}}">{{{ $name }}}</a></small>
        </h1>
    </div>

    {{ Form::open([
        //"url"          => URL::route("vacancies/edit"),
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
            {{ Form::text("name", $name, [
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
            {{ Form::textarea("text", $text, [
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
            {{ Form::text("company", $company, [
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
    
    <div class="form-group">
        {{ Form::label("profilePic", "Current company poster",[
            "class"  => "col-sm-4 control-label"
        ]) }}
    
        @if ($poster)
            <div class="col-sm-4">
                <img src="{{URL::to('/')}}/{{{$poster}}}" width="100" alt="vacancie poster"/>
            </div>
        @else
            <div class="col-sm-4">
                <img src="{{URL::to('/')}}/uploads/vacanciePosters/default.jpeg" width="100" alt="vacancie poster"/>
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
    
    <div class="form-group @if ($errors->first('phone')) has-error@endif">     
        {{ Form::label("phone", "Phone number",[
            "class"  => "col-sm-4 control-label"
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
        <div class="col-sm-offset-4 col-sm-4"> 
        {{ Form::submit("Edit vacancie",["class" => "btn btn-warning btn-block"]) }}
        </div>
    </div>        
    
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop