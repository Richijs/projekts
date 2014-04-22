@extends("layout")
@section("content")
    <h2>Add a vacancie</h2>

    {{ Form::open([
        "url"          => URL::route("vacancies/add"),
        "autocomplete" => "off",
        "enctype" => "multipart/form-data",
        "file" => "true"
    ]) }}
    
    <div>    
        {{ Form::label("vacancieName", "Vacancie Name") }}
        {{ Form::text("name", Input::get("name"), [
            "placeholder" => "Vacancie Name"
        ]) }}
        @if ($error = $errors->first("name"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>   
    
    <div>    
        {{ Form::label("vacancieText", "Vacancie Text") }}
        {{ Form::textarea("text", Input::get("text"), [
            "placeholder" => "Vacancie Text"
        ]) }}
        @if ($error = $errors->first("text"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>   
    
    <div>   
        {{ Form::label("poster", "Vacancie Poster") }}
        {{ Form::file("poster", Input::file("poster"), [ //input::get varbūt???  lkm input::old nestrādā uz file :(
            "placeholder" => "Vacancie Poster"
        ]) }}
        @if ($error = $errors->first("poster"))
            <div class="error">
                {{ $error }}
            </div>
        @endif
    </div>  
    
    <div>   
        {{ Form::submit("Add vacancie") }}
    </div>
    {{ Form::close() }}
@stop
@section("footer")
    @parent
    <script src="/js/polyfill.io"></script>
@stop