@extends("layout")
@section("content")

    <div class="page-header">
        <h1>Editing <a href="{{URL::to("/viewUser/".$userId)}}">{{{$userName}}}</a>
            <a href="{{URL::to("/viewApplication/".$applicationId)}}">application</a> for 
            <small><a href="{{URL::to("/viewVacancie/".$vacancieId)}}">this vacancie</a></small>
        </h1>
    </div>

    {{ Form::open([
        "autocomplete" => "off",
        "class"        => "form-horizontal",
        "role"         => "form"
    ]) }}
      
    <div class="form-group @if ($errors->first('letter')) has-error@endif">    
        {{ Form::label("letter", "Apply letter",[
            "class"  => "col-sm-2 control-label required"
        ]) }}
        
        <div class="col-sm-8">
            {{ Form::textarea("letter", $letter, [
                "placeholder" => "Letter Text",
                "class"       => "form-control",
                "rows"        => "10"
            ]) }}
        </div>
        
        @if ($error = $errors->first("letter"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>   
    
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-4">  
            {{ Form::submit("edit Application",["class" => "btn btn-warning btn-block"]) }}
        </div>
    </div>
    
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop