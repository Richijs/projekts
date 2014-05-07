@extends("layout")
@section("content")
    <h2>Applying for vacancie:</h2>
    <h3><a href="/viewVacancie/{{{$vacancieId}}}">{{{ $vacancieName }}}</a></h3>

    {{ Form::open([
        //"url"          => URL::route("applications/apply"),
        "autocomplete" => "off",
    ]) }}
      
    
    <div>    
        {{ Form::label("letter", "Apply letter") }}
        {{ Form::textarea("letter", Input::get("letter"), [
            "placeholder" => "Letter Text"
        ]) }}
        @if ($error = $errors->first("letter"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>   
    
    <div>   
        {{ Form::submit("Apply Job",["class" => "btn btn-success"]) }}
    </div>
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop