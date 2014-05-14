@extends("layout")
@section("content")
    
    <div class="page-header">
        <h1>
            Delete <a href="{{URL::to("/viewSeeker/".$id)}}">{{{ $intro }}}</a> job seek data
            <div><small>To delete Job Seek, Confirm deletion</small></div>
        </h1>
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
                {{ Form::label("checkbox","I Wish to delete my job seeker data") }}
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
            {{ Form::submit("Delete Job Seek",["class" => "btn btn-danger btn-block"]) }}
        </div>
    </div>
        
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop