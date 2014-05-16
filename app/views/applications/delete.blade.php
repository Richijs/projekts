@extends("layout")
@section("content")

<div class="page-header">
    <h1>Delete <a href="{{URL::to("/viewApplication/".$applicationId)}}">Application</a> to 
        <small><a href="{{URL::to("/viewVacancie/".$vacancieId)}}">{{{ $vacancieName }}}</a></small>
        <div><small>To delete Application, Confirm deletion</small></div>
    </h1>
</div>

<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title">
            <b>Written letter:</b>
        </div>
    </div>
    <div class="panel-body newlineText">
        {{{$applicationLetter}}}
    </div>
</div>
  

    {{ Form::open([
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