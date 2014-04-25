@extends("layout")
@section("content")
<h2>Delete 
    <a href="/viewApplication/{{{$applicationId}}}">Application</a>
    for
    <a href="/viewVacancie/{{{$vacancieId}}}">{{{ $vacancieName }}}</a>
</h2>
    <h3>With letter:</h3>
    <div>
        {{{$applicationLetter}}}
    </div>
    
    <h3>To delete Application, Confirm deletionn</h3>

    {{ Form::open([
        //"url"          => URL::route("applications/delete"),
        "autocomplete" => "off"
    ]) }}
    
        {{ Form::checkbox("checkbox", 1 ,[
            
        ]) }}
        {{ Form::label("checkbox","I Wish to delete my application data") }}
        
        @if ($error = $errors->first("checkbox"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
        
        {{ Form::submit("Delete Application") }}
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop