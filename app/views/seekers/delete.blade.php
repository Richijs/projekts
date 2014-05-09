@extends("layout")
@section("content")
<h2>Delete <a href="/viewVacancie/{{{$id}}}">{{{ $intro }}}</a> job seek data</h2>
    <h3>To delete Job Seek, Confirm deletionn</h3>

    {{ Form::open([
        //"url"          => URL::route("vacancies/delete"),
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