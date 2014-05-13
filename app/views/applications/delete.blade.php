@extends("layout")
@section("content")

<div class="page-header">
    <h1>Delete <a href="/viewApplication/{{{$applicationId}}}">Application</a> for 
        <small><a href="/viewVacancie/{{{$vacancieId}}}">{{{ $vacancieName }}}</a></small>
        
        <div><small>To delete Application, Confirm deletion</small></div>
    </h1>
</div>

    <h3>Written letter:</h3>
    <div>
        {{{$applicationLetter}}}
    </div>
    

    {{ Form::open([
        //"url"          => URL::route("applications/delete"),
        "autocomplete" => "off",
        "class"        => "form-horizontal",
        "role"         => "form"
    ]) }}
    
    <div class="form-group @if ($errors->first('checkbox')) has-error@endif">
        {{ Form::label("confirmation", "Confirmation",[
            "class"  => "col-sm-4 control-label required"
        ]) }}
        
        <div class="col-sm-4">
                <div class="checkbox">
                    {{ Form::checkbox("checkbox",true,false,[
                        "id" => "checkbox"
                    ]) }}
                    {{ Form::label("checkbox","I Wish to delete this application") }}
                </div>
        </div>
        
        @if ($error = $errors->first("checkbox"))
            <div class="error col-sm-offset-4 col-sm-4">
                {{ $error }}
            </div>
        @endif
    </div>
    
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-4">
            {{ Form::submit("Delete Application",["class" => "btn btn-danger btn-block"]) }}
        </div>
    </div>
    
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop