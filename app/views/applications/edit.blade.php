@extends("layout")
@section("content")
    <h2>Editing 
        <a href="/viewUser/{{{$userId}}}">{{{$userName}}}</a>'s
        <a href="/viewApplication/{{{$applicationId}}}">application</a>
        for:
        <a href="/viewVacancie/{{{$vacancieId}}}">this vakancie</a>
    </h2>
    {{ Form::open([
        //"url"          => URL::route("applications/edit"),
        "autocomplete" => "off",
    ]) }}
      
    
    <div>    
        {{ Form::label("letter", "Apply letter") }}
        {{ Form::textarea("letter", $letter, [
            "placeholder" => "Letter Text"
        ]) }}
        @if ($error = $errors->first("letter"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>   
    
    <div>   
        {{ Form::submit("edit Application") }}
    </div>
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop