@extends("layout")
@section("content")
<h2>Delete <a href="/viewVacancie/{{{$id}}}">{{{ $intro }}}</a> job seek data</h2>
    <h3>To delete Job Seek, Confirm deletionn</h3>

    {{ Form::open([
        //"url"          => URL::route("vacancies/delete"),
        "autocomplete" => "off"
    ]) }}
    
        {{ Form::checkbox("checkbox", 1 ,[
            
        ]) }}
        {{ Form::label("checkbox","I Wish to delete my job seeker data") }}
        
        @if ($error = $errors->first("checkbox"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
        
        {{ Form::submit("Delete Job Seek") }}
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop